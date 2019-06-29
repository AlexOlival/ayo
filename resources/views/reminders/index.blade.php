@if($upcomingReminderCount)
    <reminder-list period="{{ \App\Constants\ReminderPeriod::UPCOMING }}"
                   :reminders="{{ json_encode($upcomingReminders) }}" :reminder-count="{{ $upcomingReminderCount }}">
    </reminder-list>
@endif

@if($nextWeekReminderCount)
    <reminder-list period="{{ \App\Constants\ReminderPeriod::NEXT_WEEK }}"
                   :reminders="{{ json_encode($nextWeekReminders) }}" :reminder-count="{{ $nextWeekReminderCount }}">
    </reminder-list>
@endif

@if($monthReminderCount)
    <reminder-list period="{{ \App\Constants\ReminderPeriod::MONTH }}"
                   :reminders="{{ json_encode($monthReminders) }}" :reminder-count="{{ $monthReminderCount }}">
    </reminder-list>
@endif

@if($laterReminderCount)
    <reminder-list period="{{ \App\Constants\ReminderPeriod::LATER }}"
                   :reminders="{{ json_encode($laterReminders) }}" :reminder-count="{{ $laterReminderCount }}">
    </reminder-list>
@endif