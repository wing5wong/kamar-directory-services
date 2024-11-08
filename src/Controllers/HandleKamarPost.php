<?php

namespace Wing5wong\KamarDirectoryServices\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;
use Wing5wong\KamarDirectoryServices\KamarData;
use Wing5wong\KamarDirectoryServices\DirectoryService\DirectoryServiceRequest;
use Wing5wong\KamarDirectoryServices\Responses\Check\Success as CheckSuccess;
use Wing5wong\KamarDirectoryServices\Responses\Check\XMLSuccess as XMLCheckSuccess;
use Wing5wong\KamarDirectoryServices\Responses\Standard\{Success, MissingData};
use Wing5wong\KamarDirectoryServices\Responses\Standard\{XMLSuccess, XMLMissingData};

class HandleKamarPost extends Controller
{
    public function __construct(
        protected KamarData $data,
        protected DirectoryServiceRequest $request
    ) {
        $this->data = KamarData::fromRequest($request);
    }

    public function __invoke()
    {
        if ($this->data->isMissing()) {
            return $this->handleMissingDataResponse();
        } elseif ($this->data->isSyncCheck()) {
            return $this->handleSyncCheckResponse();
        } else {
            return $this->handleOKResponse();
        }
    }

    private function handleMissingDataResponse()
    {
        if ($this->data->isJson()) {
            return response()->json(new MissingData());
        }
        if ($this->data->isXml()) {
            return response()->xml((string)(new XmlMissingData()));
        }
    }

    private function handleSyncCheckResponse()
    {
        if ($this->data->isJson()) {
            return response()->json(new CheckSuccess(
                $this->data->getDateTime(),
                $this->data->getVersion(),
            ));
        }
        if ($this->data->isXml()) {
            return response()->xml((string)(new XmlCheckSuccess()));
        }
    }

    private function handleOKResponse()
    {
        $this->storeKamarData();

        if ($this->data->isJson()) {
            return response()->json(new Success());
        }
        if ($this->data->isXml()) {
            return response()->xml((string)(new XmlSuccess()));
        }
    }

    private function storeKamarData()
    {
        $filename = $this->data->generateFilename();
        Storage::disk(config('kamar-directory-services.storageDisk'))
            ->put(
                config('kamar-directory-services.storageFolder') . DIRECTORY_SEPARATOR . $filename,
                $this->request->getContent()
            );
    }
}
