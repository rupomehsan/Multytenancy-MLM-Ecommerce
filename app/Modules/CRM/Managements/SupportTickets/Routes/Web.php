<?php


use Illuminate\Support\Facades\Route;
use App\Modules\CRM\Managements\SupportTickets\Controllers\SupportTicketController;
/*
|--------------------------------------------------------------------------
| Support Ticket Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for support ticket management in the CRM module. These
|
*/

Route::get('/pending/support/tickets', [SupportTicketController::class, 'pendingSupportTickets'])->name('PendingSupportTickets');
Route::get('/solved/support/tickets', [SupportTicketController::class, 'solvedSupportTickets'])->name('SolvedSupportTickets');
Route::get('/on/hold/support/tickets', [SupportTicketController::class, 'onHoldSupportTickets'])->name('OnHoldSupportTickets');
Route::get('/rejected/support/tickets', [SupportTicketController::class, 'rejectedSupportTickets'])->name('RejectedSupportTickets');
Route::get('/delete/support/ticket/{slug}', [SupportTicketController::class, 'deleteSupportTicket'])->name('DeleteSupportTicket');
Route::get('/support/status/change/{slug}', [SupportTicketController::class, 'changeStatusSupport'])->name('ChangeStatusSupport');
Route::get('/support/status/on/hold/{slug}', [SupportTicketController::class, 'changeStatusSupportOnHold'])->name('ChangeStatusSupportOnHold');
Route::get('/support/status/in/progress/{slug}', [SupportTicketController::class, 'changeStatusSupportInProgress'])->name('ChangeStatusSupportInProgress');
Route::get('/support/status/rejected/{slug}', [SupportTicketController::class, 'changeStatusSupportRejected'])->name('ChangeStatusSupportRejected');
Route::get('/view/support/messages/{slug}', [SupportTicketController::class, 'viewSupportMessage'])->name('ViewSupportMessage');
Route::post('/send/support/message', [SupportTicketController::class, 'sendSupportMessage'])->name('SendSupportMessage');
