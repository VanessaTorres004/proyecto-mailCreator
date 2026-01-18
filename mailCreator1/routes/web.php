<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CampaignsController;
use App\Http\Controllers\CampaignsNewEditorController;
use App\Http\Controllers\BlocksController;
use App\Http\Controllers\NotificationsController;
use App\Http\Controllers\RolePermissionsController;

Route::get('/', [LoginController::class, 'showLoginForm'])->name('login');

Auth::routes();
Auth::routes(['register' => false]);

Route::middleware(['auth', 'breadcrumbs'])->group(function () {
    
    /* RUTAS DE USUARIOS */
    Route::get('/home', [UserController::class, 'dashboard'])->name('home');
    Route::get('users/list', [UserController::class, 'listUsers'])->name('users.list');
    Route::get('users/add', [UserController::class, 'createUser'])->name('users.add');
    Route::post('users/store', [UserController::class, 'createUser'])->name('users.store');
    Route::get('users/edit/{id}', [UserController::class, 'editUser'])->name('users.edit');
    Route::post('users/update/{id}', [UserController::class, 'editUser'])->name('users.update');
    Route::delete('users/delete/{id}', [UserController::class, 'deleteUser'])->name('users.destroy');
    
    /* RUTAS DE CAMPAÑAS */
    Route::get('campaigns/list', [CampaignsController::class, 'listCampaigns'])->name('campaigns.list');
    Route::match(['get', 'post'], 'campaigns/add', [CampaignsController::class, 'createCampaign'])->name('campaigns.add');
    Route::match(['get', 'post'], 'campaigns/edit/{id}', [CampaignsController::class, 'editCampaign']);
    Route::get('campaigns/delete/{id}', [CampaignsController::class, 'deleteCampaign']);
    Route::get('campaigns/download/{id}', [CampaignsController::class, 'downloadCampaign']);
    Route::get('campaigns/copy/{id}', [CampaignsController::class, 'copyCampaign']);
    Route::get('view/{id}', [CampaignsController::class, 'viewCampaign'])->name('campaigns.view');
    Route::get('/send/{id}', [CampaignsController::class, 'send'])->name('campaigns.send');

    /* RUTAS BLOQUES */
    Route::get('blocks/list/{id}', [BlocksController::class, 'listBlocks'])->name('blocks.list');
    Route::match(['get', 'post'], 'blocks/add', [BlocksController::class, 'addBlock'])->name('blocks.add');
    Route::match(['get', 'post'], 'blocks/edit/{id}', [BlocksController::class, 'editBlock'])->name('blocks.edit');
    Route::get('blocks/delete/{id}', [BlocksController::class, 'deleteBlock'])->name('blocks.delete');
    Route::post('/blocks/image-upload', [BlocksController::class, 'imageUpload'])->name('blocks.image-upload');
    Route::get('/preview/body/{template}', function ($template) {
        try {
            return view('components.bodies.body_' . $template)->render();
        } catch (\Throwable $e) {
            return "<div class='text-danger'>Plantilla no encontrada</div>";
        }
    });
    Route::post('blocks/reorder', [BlocksController::class, 'reorder'])->name('blocks.reorder');
    
    /* RUTAS DE COLABORACIÓN */
    // Admin routes
    Route::middleware(['role:admin'])->group(function () {
        Route::get('campaigns/delegate/{id}', [CampaignsController::class, 'showDelegateForm'])->name('campaigns.delegate');
        Route::post('campaigns/{id}/assign-collaborator', [CampaignsController::class, 'assignCollaborator'])->name('campaigns.assign-collaborator');
        Route::get('campaigns/{campaignId}/remove-collaborator/{collaboratorId}', [CampaignsController::class, 'removeCollaborator'])->name('campaigns.remove-collaborator');
        
        /* RUTAS DE GESTIÓN DE ROLES Y PERMISOS */
        Route::prefix('admin/roles')->name('admin.roles.')->group(function () {
            Route::get('/', [RolePermissionsController::class, 'index'])->name('index');
            Route::get('/{role}/edit', [RolePermissionsController::class, 'edit'])->name('edit');
            Route::post('/create', [RolePermissionsController::class, 'createRole'])->name('create');
            Route::put('/{roleName}', [RolePermissionsController::class, 'updatePermissions'])->name('update');
            Route::delete('/{roleId}', [RolePermissionsController::class, 'deleteRole'])->name('delete');
        });
    });

    // Marketing routes
 Route::middleware(['role:marketing|facultades'])->group(function () {
    Route::get('my-collaborations', [CampaignsController::class, 'myCollaborations'])->name('campaigns.my-collaborations');
});
    // Shared routes (admin and marketing)
    Route::post('campaigns/collaboration/{id}/update-status', [CampaignsController::class, 'updateCollaborationStatus'])->name('campaigns.update-collaboration-status');

    /* RUTAS DE NOTIFICACIONES */
    Route::get('notifications', [NotificationsController::class, 'index'])->name('notifications.index');
    Route::get('notifications/{id}/mark-read', [NotificationsController::class, 'markAsRead'])->name('notifications.mark-read');
    Route::get('notifications/mark-all-read', [NotificationsController::class, 'markAllAsRead'])->name('notifications.mark-all-read');
    Route::get('notifications/unread-count', [NotificationsController::class, 'getUnreadCount'])->name('notifications.unread-count');

    /* CAMPAÑAS NUEVO EDITOR */
    Route::prefix('campaigns-new-editor')->group(function () {
        Route::get('list', [CampaignsNewEditorController::class, 'listCampaigns'])->name('campaignsneweditor.list');
        Route::get('add', [CampaignsNewEditorController::class, 'createCampaigns'])->name('campaignsneweditor.add');
    });
});