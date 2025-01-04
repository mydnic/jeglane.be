<?php

use Illuminate\Support\Facades\Schedule;

Schedule::command('gleaning:archive-old')->daily();
