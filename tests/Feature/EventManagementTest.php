<?php

namespace Tests\Feature;

use App\Models\Event;
use App\Models\EventRegistration;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EventManagementTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;
    private User $employee;
    private Event $openEvent;
    private Event $closedEvent;
    private Event $completedEvent;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::create([
            'name'       => 'Admin Test',
            'email'      => 'admin@test.com',
            'password'   => bcrypt('password'),
            'role'       => 'admin',
            'department' => 'HR',
        ]);

        $this->employee = User::create([
            'name'       => 'Employee Test',
            'email'      => 'employee@test.com',
            'password'   => bcrypt('password'),
            'role'       => 'employee',
            'department' => 'Engineering',
        ]);

        $this->openEvent = Event::create([
            'title'       => 'Open Tennis Tournament',
            'category'    => 'Tennis',
            'description' => 'A test tennis event.',
            'event_date'  => Carbon::today()->addDays(3)->toDateString(),
            'event_time'  => '17:00:00',
            'location'    => 'Court A',
            'quota'       => 10,
            'points'      => 30,
            'status'      => 'Open',
            'image'       => 'tennis.png',
        ]);

        $this->closedEvent = Event::create([
            'title'       => 'Closed Yoga Session',
            'category'    => 'Yoga',
            'description' => 'A closed yoga session.',
            'event_date'  => Carbon::today()->addDays(5)->toDateString(),
            'event_time'  => '09:00:00',
            'location'    => 'Rooftop',
            'quota'       => 5,
            'points'      => 20,
            'status'      => 'Closed',
            'image'       => 'yoga.png',
        ]);

        $this->completedEvent = Event::create([
            'title'       => 'Completed Pilates',
            'category'    => 'Pilates',
            'description' => 'A past pilates class.',
            'event_date'  => Carbon::today()->subDays(2)->toDateString(),
            'event_time'  => '08:00:00',
            'location'    => 'Studio B',
            'quota'       => 25,
            'points'      => 15,
            'status'      => 'Completed',
            'image'       => 'pilates.png',
        ]);
    }

    // =========================================================================
    // EMPLOYEE: Event Listing
    // =========================================================================

    public function test_employee_can_view_event_list(): void
    {
        $response = $this->actingAs($this->employee)
            ->get(route('events.index'));

        $response->assertStatus(200);
        $response->assertSee('Open Tennis Tournament');
        // Completed events should NOT appear in the upcoming list
        $response->assertDontSee('Completed Pilates');
    }

    public function test_guest_cannot_access_event_list(): void
    {
        $response = $this->get(route('events.index'));
        $response->assertRedirect(route('login'));
    }

    // =========================================================================
    // EMPLOYEE: Event Details
    // =========================================================================

    public function test_employee_can_view_open_event_details(): void
    {
        $response = $this->actingAs($this->employee)
            ->get(route('events.show', $this->openEvent));

        $response->assertStatus(200);
        $response->assertSee('Open Tennis Tournament');
        $response->assertSee('Join Event');
    }

    public function test_employee_sees_pending_status_on_registered_event(): void
    {
        EventRegistration::create([
            'user_id'    => $this->employee->id,
            'event_id'   => $this->openEvent->id,
            'attendance' => 'Pending',
        ]);

        $response = $this->actingAs($this->employee)
            ->get(route('events.show', $this->openEvent));

        $response->assertStatus(200);
        $response->assertSee('Registration Pending');
    }

    // =========================================================================
    // EMPLOYEE: Joining Events
    // =========================================================================

    public function test_employee_can_join_open_event(): void
    {
        $response = $this->actingAs($this->employee)
            ->post(route('events.join', $this->openEvent));

        $response->assertRedirect(route('events.show', $this->openEvent));
        $this->assertDatabaseHas('event_registrations', [
            'user_id'    => $this->employee->id,
            'event_id'   => $this->openEvent->id,
            'attendance' => 'Pending',
        ]);
    }

    public function test_employee_cannot_join_same_event_twice(): void
    {
        EventRegistration::create([
            'user_id'    => $this->employee->id,
            'event_id'   => $this->openEvent->id,
            'attendance' => 'Pending',
        ]);

        $response = $this->actingAs($this->employee)
            ->post(route('events.join', $this->openEvent));

        $response->assertRedirect();
        $response->assertSessionHas('error', 'You have already registered for this event.');
        $this->assertDatabaseCount('event_registrations', 1);
    }

    public function test_employee_cannot_join_closed_event(): void
    {
        $response = $this->actingAs($this->employee)
            ->post(route('events.join', $this->closedEvent));

        $response->assertRedirect();
        $response->assertSessionHas('error', 'This event is closed or completed and cannot be joined.');
        $this->assertDatabaseEmpty('event_registrations');
    }

    public function test_employee_cannot_join_completed_event(): void
    {
        $response = $this->actingAs($this->employee)
            ->post(route('events.join', $this->completedEvent));

        $response->assertRedirect();
        $response->assertSessionHas('error', 'This event is closed or completed and cannot be joined.');
        $this->assertDatabaseEmpty('event_registrations');
    }

    public function test_employee_cannot_join_full_event(): void
    {
        $fullEvent = Event::create([
            'title'       => 'Full Padel Match',
            'category'    => 'Padel',
            'description' => 'This event is full.',
            'event_date'  => Carbon::today()->addDays(4)->toDateString(),
            'event_time'  => '16:00:00',
            'location'    => 'Padel Arena',
            'quota'       => 1,
            'points'      => 25,
            'status'      => 'Open',
            'image'       => 'padel.png',
        ]);

        $otherEmployee = User::create([
            'name'       => 'Another Employee',
            'email'      => 'another@test.com',
            'password'   => bcrypt('password'),
            'role'       => 'employee',
            'department' => 'Finance',
        ]);
        EventRegistration::create([
            'user_id'    => $otherEmployee->id,
            'event_id'   => $fullEvent->id,
            'attendance' => 'Pending',
        ]);

        $response = $this->actingAs($this->employee)
            ->post(route('events.join', $fullEvent));

        $response->assertRedirect();
        $response->assertSessionHas('error', 'This event is already full.');
    }

    // =========================================================================
    // EMPLOYEE: My Events
    // =========================================================================

    public function test_employee_can_view_my_events_page(): void
    {
        EventRegistration::create([
            'user_id'    => $this->employee->id,
            'event_id'   => $this->openEvent->id,
            'attendance' => 'Pending',
        ]);

        $response = $this->actingAs($this->employee)
            ->get(route('events.my-events'));

        $response->assertStatus(200);
        $response->assertSee('Open Tennis Tournament');
    }

    // =========================================================================
    // ADMIN: Attendance Marking
    // =========================================================================

    public function test_admin_can_mark_attendance_as_present(): void
    {
        $registration = EventRegistration::create([
            'user_id'    => $this->employee->id,
            'event_id'   => $this->openEvent->id,
            'attendance' => 'Pending',
        ]);

        $response = $this->actingAs($this->admin)
            ->post(route('admin.events.attendance', $registration), [
                'attendance' => 'Present',
            ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('event_registrations', [
            'id'         => $registration->id,
            'attendance' => 'Present',
        ]);
    }

    public function test_admin_can_mark_attendance_as_absent(): void
    {
        $registration = EventRegistration::create([
            'user_id'    => $this->employee->id,
            'event_id'   => $this->openEvent->id,
            'attendance' => 'Pending',
        ]);

        $response = $this->actingAs($this->admin)
            ->post(route('admin.events.attendance', $registration), [
                'attendance' => 'Absent',
            ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('event_registrations', [
            'id'         => $registration->id,
            'attendance' => 'Absent',
        ]);
    }

    public function test_absent_registrations_do_not_count_toward_quota(): void
    {
        EventRegistration::create([
            'user_id'    => $this->employee->id,
            'event_id'   => $this->openEvent->id,
            'attendance' => 'Pending',
        ]);
        $otherEmployee = User::create([
            'name'       => 'Absent Employee',
            'email'      => 'absent@test.com',
            'password'   => bcrypt('password'),
            'role'       => 'employee',
            'department' => 'Marketing',
        ]);
        EventRegistration::create([
            'user_id'    => $otherEmployee->id,
            'event_id'   => $this->openEvent->id,
            'attendance' => 'Absent',
        ]);

        // quota(10) - non-absent registrations(1 Pending) = 9 slots available
        $this->assertEquals(9, $this->openEvent->getAvailableSlots());
    }

    // =========================================================================
    // ADMIN: Event CRUD Views
    // =========================================================================

    public function test_admin_can_view_events_index(): void
    {
        $response = $this->actingAs($this->admin)
            ->get(route('admin.events.index'));

        $response->assertStatus(200);
    }

    public function test_admin_can_view_event_attendance_page(): void
    {
        $response = $this->actingAs($this->admin)
            ->get(route('admin.events.show', $this->openEvent));

        $response->assertStatus(200);
        $response->assertSee('Awaiting Approval');
    }

    public function test_employee_cannot_access_admin_event_management(): void
    {
        $response = $this->actingAs($this->employee)
            ->get(route('admin.events.index'));

        $this->assertNotEquals(200, $response->getStatusCode());
    }
}
