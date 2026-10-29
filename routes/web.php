<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\ScholarshipController;
use App\Http\Controllers\ResearchController;
use App\Http\Controllers\ChatbotController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/programs', [ProgramController::class, 'index'])->name('programs.index');
Route::get('/programs/{code}', [ProgramController::class, 'show'])->name('programs.show');
Route::get('/scholarships', [ScholarshipController::class, 'index'])->name('scholarships.index');
Route::get('/research', [ResearchController::class, 'index'])->name('research.index');

// Chatbot API
Route::post('/api/chatbot/send-message', [ChatbotController::class, 'sendMessage'])->name('chatbot.send');
