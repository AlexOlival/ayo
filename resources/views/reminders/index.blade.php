@if($upcomingReminderCount)
    <reminder-list period="{{ \App\Constants\ReminderPeriod::UPCOMING }}"
                   :reminders="{{ json_encode($upcomingReminders) }}" :reminder-count="{{ $upcomingReminderCount }}">
    </reminder-list>
@endif

@if($tenDaysAfterReminderCount)
    <reminder-list period="{{ \App\Constants\ReminderPeriod::TEN_DAYS_AFTER }}"
                   :reminders="{{ json_encode($tenDaysAfterReminders) }}" :reminder-count="{{ $tenDaysAfterReminderCount }}">
    </reminder-list>
@endif

@if($laterReminderCount)
    <reminder-list period="{{ \App\Constants\ReminderPeriod::LATER }}"
                   :reminders="{{ json_encode($laterReminders) }}" :reminder-count="{{ $laterReminderCount }}">
    </reminder-list>
@endif
