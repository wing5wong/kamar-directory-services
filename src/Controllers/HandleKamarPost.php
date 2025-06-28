<?php

namespace Wing5wong\KamarDirectoryServices\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;
use Wing5wong\KamarDirectoryServices\KamarData;
use Wing5wong\KamarDirectoryServices\DirectoryService\DirectoryServiceRequest;
use Wing5wong\KamarDirectoryServices\Events\AttendanceDataReceived;
use Wing5wong\KamarDirectoryServices\Events\CalendarDataReceived;
use Wing5wong\KamarDirectoryServices\Events\KamarPostStored;
use Wing5wong\KamarDirectoryServices\Events\NoticeDataReceived;
use Wing5wong\KamarDirectoryServices\Events\PastoralDataReceived;
use Wing5wong\KamarDirectoryServices\Events\RecognitionDataReceived;
use Wing5wong\KamarDirectoryServices\Events\StaffDataReceived;
use Wing5wong\KamarDirectoryServices\Events\StudentDataReceived;
use Wing5wong\KamarDirectoryServices\Responses\Check\Success as CheckSuccess;
use Wing5wong\KamarDirectoryServices\Responses\Check\XMLSuccess as XMLCheckSuccess;
use Wing5wong\KamarDirectoryServices\Responses\Standard\{Success, MissingData};
use Wing5wong\KamarDirectoryServices\Responses\Standard\{XMLSuccess, XMLMissingData};

class HandleKamarPost extends Controller
{
    private const SYNC_EVENT_MAP = [
        KamarData::SYNC_TYPE_PART  => [
            [StaffDataReceived::class, 'getStaff'],
            [StudentDataReceived::class, 'getStudents'],
        ],
        KamarData::SYNC_TYPE_FULL  => [
            [StaffDataReceived::class, 'getStaff'],
            [StudentDataReceived::class, 'getStudents'],
        ],
        KamarData::SYNC_TYPE_PASTORAL     => [[PastoralDataReceived::class, 'getPastoral']],
        KamarData::SYNC_TYPE_ATTENDANCE   => [[AttendanceDataReceived::class, 'getAttendance']],
        KamarData::SYNC_TYPE_RECOGNITIONS => [[RecognitionDataReceived::class, 'getRecognitions']],
        KamarData::SYNC_TYPE_NOTICES      => [[NoticeDataReceived::class, 'getNotices']],
        KamarData::SYNC_TYPE_CALENDAR      => [[CalendarDataReceived::class, 'getCalendar']],
    ];

    protected KamarData $data;

    public function __construct(
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
            return response()->xml((string)(new XMLMissingData()));
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

        $this->sendOkEvents();

        if ($this->data->isJson()) {
            return response()->json(new Success());
        }
        if ($this->data->isXml()) {
            return response()->xml((string)(new XmlSuccess()));
        }
    }

    private function sendOkEvents()
    {
        $currentType = $this->data->getSyncType();

        if (isset(self::SYNC_EVENT_MAP[$currentType])) {
            foreach (self::SYNC_EVENT_MAP[$currentType] as [$eventClass, $getter]) {
                event(new $eventClass($this->data->{$getter}()));
            }
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
        //event(new KamarPostStored($filename));
    }
}
