<?php

namespace Wing5wong\KamarDirectoryServices\Tests\Feature;

use Spatie\ArrayToXml\ArrayToXml;
use Wing5wong\KamarDirectoryServices\DirectoryService\DirectoryServiceRequest;
use Wing5wong\KamarDirectoryServices\KamarData;
use Wing5wong\KamarDirectoryServices\Tests\TestCase;

class KamarDataTest extends TestCase
{
    public function test_is_missing_returns_true_when_no_data()
    {
        $this->assertTrue((new KamarData)->isMissing());
    }

    public function test_isMissing_returns_true_when_request_is_blank()
    {
        $this->assertTrue(KamarData::fromRequest($this->blankRequest())->isMissing());
    }

    public function test_isMissing_returns_true_when_XMLrequest_is_blank()
    {
        $this->assertTrue(KamarData::fromRequest($this->blankXMLRequest())->isMissing());
    }

    public function test_isMissing_returns_true_when_request_SMSDirectoryData_is_empty_array()
    {
        $this->assertTrue((KamarData::fromRequest($this->emptyRequest()))->isMissing());
    }

    public static function isSyncTypeDataProvider()
    {
        return [
            [KamarData::SYNC_TYPE_CHECK,  'isSyncCheck'],
            [KamarData::SYNC_TYPE_PART,  'isSyncPart'],
            [KamarData::SYNC_TYPE_FULL,  'isSyncFull'],
        ];
    }

    /**
     * @dataProvider isSyncTypeDataProvider()
     */
    public function test_is_sync_type_returns_true_for_correct_method($syncType, $syncTypeMethod)
    {
        $kamar = KamarData::fromRequest($this->genericSyncRequest($syncType));
        $this->assertTrue($kamar->$syncTypeMethod());
    }


    public function test_can_get_verson_and_datetime_from_check_request()
    {
        $version = "2198";
        $datetime = "20221122111106";

        $request = new DirectoryServiceRequest();
        $request->headers->set('content-type', 'application/json');
        $request->merge(
            [
                'SMSDirectoryData' => [
                    'sync' => KamarData::SYNC_TYPE_CHECK,
                    "version" => $version,
                    "datetime" => $datetime
                ]
            ]
        );

        $kamar = KamarData::fromRequest($request);

        $this->assertSame($version, $kamar->getVersion());
        $this->assertSame($datetime, $kamar->getDateTime());
    }

    /**
     * @dataProvider isSyncTypeDataProvider()
     */
    public function test_is_sync_type_returns_true_for_correct_method_xml_request($syncType, $syncTypeMethod)
    {
        $kamar = KamarData::fromRequest($this->genericXMLSyncRequest($syncType));
        $this->assertTrue($kamar->$syncTypeMethod());
    }

    public static function incorrectIsSyncTypeDataProvider()
    {
        return [
            [KamarData::SYNC_TYPE_PART,  'isSyncCheck'],
            [KamarData::SYNC_TYPE_FULL,  'isSyncPart'],
            [KamarData::SYNC_TYPE_CHECK,  'isSyncFull'],
        ];
    }

    /**
     * @dataProvider incorrectIsSyncTypeDataProvider()
     */
    public function test_is_sync_type_returns_false_for_incorrect_method($syncType, $syncTypeMethod)
    {
        $kamar = KamarData::fromRequest($this->genericSyncRequest($syncType));
        $this->assertFalse($kamar->$syncTypeMethod());
    }

    /**
     * @dataProvider incorrectIsSyncTypeDataProvider()
     */
    public function test_is_sync_type_returns_false_for_incorrect_method_xml_request($syncType, $syncTypeMethod)
    {
        $kamar = KamarData::fromRequest($this->genericXMLSyncRequest($syncType));
        $this->assertFalse($kamar->$syncTypeMethod());
    }

    public static function syncTypeDataProvider()
    {
        return     [
            ['SYNC_TYPE_CHECK', 'check'],
            ['SYNC_TYPE_PART', 'part'],
            ['SYNC_TYPE_FULL', 'full'],
            ['SYNC_TYPE_ASSESSMENTS', 'assessments'],
            ['SYNC_TYPE_ATTENDANCE', 'attendance'],
            ['SYNC_TYPE_BOOKINGS', 'bookings'],
            ['SYNC_TYPE_CALENDAR', 'calendar'],
            ['SYNC_TYPE_NOTICES', 'notices'],
            ['SYNC_TYPE_PASTORAL', 'pastoral'],
            ['SYNC_TYPE_PHOTOS', 'photos'],
            ['SYNC_TYPE_STAFFPHOTOS', 'staffphotos'],
            ['SYNC_TYPE_STUDENTTIMETABLES', 'studenttimetables'],
            ['SYNC_TYPE_STAFFTIMETABLES', 'stafftimetables'],
        ];
    }

    /**
     * @dataProvider syncTypeDataProvider
     */
    public function test_itGetsTheCorrectSyncType($syncConst, $syncType)
    {
        $kamar = KamarData::fromRequest($this->genericSyncRequest($syncType));
        $this->assertSame(
            constant("Wing5wong\KamarDirectoryServices\KamarData::$syncConst"),
            $kamar->getSyncType()
        );
    }

    /**
     * @dataProvider syncTypeDataProvider
     */
    public function test_itGetsTheCorrectXMLSyncType($syncConst, $syncType)
    {
        $kamar = KamarData::fromRequest($this->genericXMLSyncRequest($syncType));
        $this->assertSame(
            constant("Wing5wong\KamarDirectoryServices\KamarData::$syncConst"),
            $kamar->getSyncType()
        );
    }

    public function test_it_creates_part_sync_from_file()
    {
        $kamar = KamarData::fromFile(__DIR__ . '/../Stubs/partRequest.json', false);
        $this->assertTrue($kamar->isSyncPart());
    }

    public function test_it_creates_full_sync_from_file()
    {
        $kamar = KamarData::fromFile(__DIR__ . '/../Stubs/fullRequest.json', false);
        $this->assertTrue($kamar->isSyncFull());
    }

    public function test_it_returns_students_from_a_full_sync()
    {
        $kamar = KamarData::fromFile(__DIR__ . '/../Stubs/fullRequest.json', false);
        $this->assertCount(1, $kamar->getStudents());
    }

    public function test_it_returns_empty_collection_for_students_from_incorrect_sync_type()
    {
        $kamar = KamarData::fromFile(__DIR__ . '/../Stubs/stafftimetables.json', false);
        $this->assertCount(0, $kamar->getStudents());
    }

    public function test_it_returns_staff_from_a_full_sync()
    {
        $kamar = KamarData::fromFile(__DIR__ . '/../Stubs/fullRequest.json', false);
        $this->assertCount(1, $kamar->getStaff());
    }

    public function test_it_returns_empty_collection_for_staff_from_incorrect_sync_type()
    {
        $kamar = KamarData::fromFile(__DIR__ . '/../Stubs/studenttimetables.json', false);
        $this->assertCount(0, $kamar->getStaff());
    }

    public function test_it_returns_stafftimetables_from_a_stafftimetable_sync()
    {
        $kamar = KamarData::fromFile(__DIR__ . '/../Stubs/stafftimetables.json', false);
        $this->assertCount(1, $kamar->getStaffTimetables());
    }

    public function test_it_returns_empty_collection_for_stafftimetables_from_incorrect_sync_type()
    {
        $kamar = KamarData::fromFile(__DIR__ . '/../Stubs/studenttimetables.json', false);
        $this->assertCount(0, $kamar->getStaffTimetables());
    }

    public function test_it_returns_studenttimetables_from_a_studenttimetable_sync()
    {
        $kamar = KamarData::fromFile(__DIR__ . '/../Stubs/studenttimetables.json', false);
        $this->assertCount(1, $kamar->getStudentTimetables());
    }

    public function test_it_returns_empty_collection_for_studenttimetables_from_incorrect_sync_type()
    {
        $kamar = KamarData::fromFile(__DIR__ . '/../Stubs/stafftimetables.json', false);
        $this->assertCount(0, $kamar->getStudentTimetables());
    }

    public function test_it_returns_attendances_from_an_attendance_sync()
    {
        $kamar = KamarData::fromFile(__DIR__ . '/../Stubs/attendance.json', false);
        $this->assertCount(1, $kamar->getAttendance());
    }

    public function test_it_returns_pastorals_from_a_pastoral_sync()
    {
        $kamar = KamarData::fromFile(__DIR__ . '/../Stubs/pastoral.json', false);
        $this->assertCount(1, $kamar->getPastoral());
    }

    public function test_it_returns_results_from_a_results_sync()
    {
        $kamar = KamarData::fromFile(__DIR__ . '/../Stubs/results.json', false);
        $this->assertCount(1, $kamar->getResults());
    }

    private function emptyRequest()
    {
        $request = new DirectoryServiceRequest();
        $request->headers->set('content-type', 'application/json');
        $request->merge(['SMSDirectoryData' => []]);
        return $request;
    }

    private function blankRequest()
    {
        $request = new DirectoryServiceRequest();
        $request->headers->set('content-type', 'application/json');
        return $request;
    }

    private function blankXMLRequest()
    {
        $request = new DirectoryServiceRequest();
        $request->headers->set('content-type', 'application/xml');
        return $request;
    }

    private function genericXMLSyncRequest($syncType)
    {
        $request = DirectoryServiceRequest::create('/', 'POST', [], [], [], [], ArrayToXml::convert(['@attributes' => ['sync' => $syncType]], 'SMSDirectoryData'));
        $request->headers->set('content-type', 'application/xml');
        return $request;
    }

    private function genericSyncRequest($syncType)
    {
        $request = new DirectoryServiceRequest();
        $request->headers->set('content-type', 'application/json');
        $request->merge(
            [
                'SMSDirectoryData' => [
                    'sync' => $syncType,
                ]
            ]
        );
        return $request;
    }
}
