<?php

namespace Wing5wong\KamarDirectoryServices\Tests\Unit;

use Illuminate\Http\Request;
use Spatie\ArrayToXml\ArrayToXml;
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
        $this->setupBlankRequest();
        $this->assertTrue(KamarData::fromRequest()->isMissing());
    }

    public function test_isMissing_returns_true_when_XMLrequest_is_blank()
    {
        $this->setupBlankXMLRequest();
        $this->assertTrue(KamarData::fromRequest()->isMissing());
    }

    public function test_isMissing_returns_true_when_request_SMSDirectoryData_is_empty_array()
    {
        $this->setupEmptyRequest();
        $this->assertTrue((KamarData::fromRequest())->isMissing());
    }

    public function isSyncTypeDataProvider()
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
        $this->setupGenericSyncRequest($syncType);
        $kamar = KamarData::fromRequest();
        $this->assertTrue($kamar->$syncTypeMethod());
    }

    /**
     * @dataProvider isSyncTypeDataProvider()
     */
    public function test_is_sync_type_returns_true_for_correct_method_xml_request($syncType, $syncTypeMethod)
    {
        $this->setupGenericXMLSyncRequest($syncType);
        $kamar = KamarData::fromRequest();
        $this->assertTrue($kamar->$syncTypeMethod());
    }

    public function incorrectIsSyncTypeDataProvider()
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
        $this->setupGenericSyncRequest($syncType);
        $kamar = KamarData::fromRequest();
        $this->assertFalse($kamar->$syncTypeMethod());
    }

    /**
     * @dataProvider incorrectIsSyncTypeDataProvider()
     */
    public function test_is_sync_type_returns_false_for_incorrect_method_xml_request($syncType, $syncTypeMethod)
    {
        $this->setupGenericXMLSyncRequest($syncType);
        $kamar = KamarData::fromRequest();
        $this->assertFalse($kamar->$syncTypeMethod());
    }

    public function syncTypeDataProvider()
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
        $this->setupGenericSyncRequest($syncType);
        $kamar = KamarData::fromRequest();
        $this->assertSame(constant("Wing5wong\KamarDirectoryServices\KamarData::$syncConst"), $kamar->getSyncType());
    }

    /**
     * @dataProvider syncTypeDataProvider
     */
    public function test_itGetsTheCorrectXMLSyncType($syncConst, $syncType)
    {
        $this->setupGenericXMLSyncRequest($syncType);
        $kamar = KamarData::fromRequest();
        $this->assertSame(constant("Wing5wong\KamarDirectoryServices\KamarData::$syncConst"), $kamar->getSyncType());
    }

    public function test_it_creates_part_sync_from_file()
    {
        $kamar = KamarData::fromFile( __DIR__ . '/Stubs/partRequest.json', false);
        $this->assertTrue($kamar->isSyncPart());
    }

    public function test_it_creates_full_sync_from_file()
    {
        $kamar = KamarData::fromFile( __DIR__ . '/Stubs/fullRequest.json', false);
        $this->assertTrue($kamar->isSyncFull());
    }

    public function test_it_returns_students_from_a_full_sync()
    {
        $kamar = KamarData::fromFile( __DIR__ . '/Stubs/fullRequest.json', false);
        $this->assertCount(1, $kamar->getStudents());
    }

    public function test_it_returns_empty_collection_for_students_from_incorrect_sync_type()
    {
        $kamar = KamarData::fromFile( __DIR__ . '/Stubs/stafftimetables.json', false);
        $this->assertCount(0, $kamar->getStudents());
    }

    public function test_it_returns_staff_from_a_full_sync()
    {
        $kamar = KamarData::fromFile( __DIR__ . '/Stubs/fullRequest.json', false);
        $this->assertCount(1, $kamar->getStaff());
    }

    public function test_it_returns_empty_collection_for_staff_from_incorrect_sync_type()
    {
        $kamar = KamarData::fromFile( __DIR__ . '/Stubs/studenttimetables.json', false);
        $this->assertCount(0, $kamar->getStaff());
    }
    
    public function test_it_returns_stafftimetables_from_a_stafftimetable_sync()
    {
        $kamar = KamarData::fromFile( __DIR__ . '/Stubs/stafftimetables.json', false);
        $this->assertCount(1, $kamar->getStaffTimetables());
    }

    public function test_it_returns_empty_collection_for_stafftimetables_from_incorrect_sync_type()
    {
        $kamar = KamarData::fromFile( __DIR__ . '/Stubs/studenttimetables.json', false);
        $this->assertCount(0, $kamar->getStaffTimetables());
    }

    public function test_it_returns_studenttimetables_from_a_studenttimetable_sync()
    {
        $kamar = KamarData::fromFile( __DIR__ . '/Stubs/studenttimetables.json', false);
        $this->assertCount(1, $kamar->getStudentTimetables());
    }

    public function test_it_returns_empty_collection_for_studenttimetables_from_incorrect_sync_type()
    {
        $kamar = KamarData::fromFile( __DIR__ . '/Stubs/stafftimetables.json', false);
        $this->assertCount(0, $kamar->getStudentTimetables());
    }
    
    public function test_it_returns_attendances_from_an_attendance_sync()
    {
        $kamar = KamarData::fromFile( __DIR__ . '/Stubs/attendance.json', false);
        $this->assertCount(1, $kamar->getAttendance());
    }

    public function test_it_returns_pastorals_from_a_pastoral_sync()
    {
        $kamar = KamarData::fromFile( __DIR__ . '/Stubs/pastoral.json', false);
        $this->assertCount(1, $kamar->getPastoral());
    }

    public function test_it_returns_results_from_a_results_sync()
    {
        $kamar = KamarData::fromFile( __DIR__ . '/Stubs/results.json', false);
        $this->assertCount(1, $kamar->getResults());
    }

    private function setupEmptyRequest()
    {
        $request = new Request();
        $request->headers->set('content-type', 'application/json');
        $request->merge(['SMSDirectoryData' => []]);
        app()->instance('request', $request);
    }

    private function setupBlankRequest()
    {
        $request = new Request();
        $request->headers->set('content-type', 'application/json');
        app()->instance('request', $request);
    }

    private function setupBlankXMLRequest()
    {
        $request = new Request();
        $request->headers->set('content-type', 'application/xml');
        app()->instance('request', $request);
    }

    private function setupGenericXMLSyncRequest($syncType)
    {
        $request = Request::create('/', 'POST', [], [], [], [], ArrayToXml::convert(['@attributes' => ['sync' => $syncType]], 'SMSDirectoryData'));
        $request->headers->set('content-type', 'application/xml');
        app()->instance('request', $request);
    }

    private function setupGenericSyncRequest($syncType)
    {
        $request = new Request();
        $request->headers->set('content-type', 'application/json');
        $request->merge(['SMSDirectoryData' => ['sync' => $syncType]]);
        app()->instance('request', $request);
    }
}
