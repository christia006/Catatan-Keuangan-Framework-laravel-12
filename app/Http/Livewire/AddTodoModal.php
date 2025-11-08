<?php

namespace App\Http\Livewire;

// Wrapper class so Livewire can resolve the component both under App\Http\Livewire
// and App\Livewire. This class simply extends the implementation in App\Livewire.
class AddTodoModal extends \App\Livewire\AddTodoModal {}
