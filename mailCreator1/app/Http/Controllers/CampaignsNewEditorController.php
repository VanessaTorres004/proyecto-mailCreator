<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\Campaigns;
use App\Models\Blocks;
use Illuminate\Support\Facades\Gate;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\BlocksController;

class CampaignsNewEditorController extends Controller
{

    public function createCampaigns(){
        return view('campaignsneweditor/form');
    }

}