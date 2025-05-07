<?php

namespace Wing5wong\KamarDirectoryServices\Controllers;

use App\Jobs\ProcessAttendance;
use App\Jobs\ProcessNotices;
use App\Jobs\ProcessPastorals;
use App\Jobs\ProcessStaff;
use App\Jobs\ProcessStudent;
use Illuminate\Routing\Controller;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Wing5wong\KamarDirectoryServices\DirectoryService\AttendanceData;
use Wing5wong\KamarDirectoryServices\KamarData;
use Wing5wong\KamarDirectoryServices\DirectoryService\DirectoryServiceRequest;
use Wing5wong\KamarDirectoryServices\DirectoryService\PastoralData;
use Wing5wong\KamarDirectoryServices\DirectoryService\StaffData;
use Wing5wong\KamarDirectoryServices\DirectoryService\StudentData;
use Wing5wong\KamarDirectoryServices\Events\KamarPostStored;
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
        //$this->storeKamarData();
        // TODO: should send events here rather tahn dispatch the job. allow consumer to listen to events and handle jobs themselves.
        $this->dispatchJobs();

        if ($this->data->isJson()) {
            return response()->json(new Success());
        }
        if ($this->data->isXml()) {
            return response()->xml((string)(new XmlSuccess()));
        }
    }
    private function dispatchJobs()
    {
        if ($this->data->isSyncPart() || $this->data->isSyncFull()) {
            $this->processMappedRecordDataOnQueue('students', ProcessStudent::class, $this->data->getStudents(), StudentData::class);
            $this->processMappedRecordDataOnQueue('staff', ProcessStaff::class, $this->data->getStaff(), StaffData::class);
        }

        if ($this->data->isSyncType(KamarData::SYNC_TYPE_PASTORAL)) {
            $this->processMappedRecordDataOnQueue('pastorals', ProcessPastorals::class, $this->data->getPastoral(), PastoralData::class);
        }

        if ($this->data->isSyncType(KamarData::SYNC_TYPE_ATTENDANCE)) {
            $this->processMappedRecordDataOnQueue('attendances', ProcessAttendance::class, $this->data->getAttendance(), AttendanceData::class);
        }

        if ($this->data->isSyncType(KamarData::SYNC_TYPE_NOTICES)) {
            ProcessNotices::dispatch($this->data->getNotices())->onQueue('notices');
        }
    }

    private function processMappedRecordDataOnQueue(string $type, string $jobClass, Collection $records, string $dataClass): void
    {
        info("[start] Processing {$type} ({$records->count()} records)");

        $records->each(function ($record, $i) use ($type, $dataClass, $jobClass) {
            $dataObject = $dataClass::fromArray($record);
            $job = new $jobClass($dataObject);

            info("Dispatching {$type} #{$i}");
            dispatch($job)->onQueue($type);
        });

        info("[finish] Processing {$type}");
    }

    private function storeKamarData()
    {
        $filename = $this->data->generateFilename();
        Storage::disk(config('kamar-directory-services.storageDisk'))
            ->put(
                config('kamar-directory-services.storageFolder') . DIRECTORY_SEPARATOR . $filename,
                $this->request->getContent()
            );
        event(new KamarPostStored($filename));
    }
}
