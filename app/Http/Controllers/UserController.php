<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Parametro;
use App\Models\Notification;
use App\Models\VerifyUser;
use App\Models\Permissions;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Datatables;
use DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Events\NotificationEvent;
use App\Events\NotificationFranchiseEvent;
use App\Traits\EmailTrait;
use App\Http\Requests\Users\UserStoreRequest;
use App\Http\Requests\Users\UserUpdateRequest;
use App\Http\Requests\Users\UserResetPasswordRequest;

class UserController extends Controller
{
    use EmailTrait;

    public function index()
    {
        $users = DB::table('users')
        ->selectRaw('users.id, users.name, users.email, users.phone, roles.rol as profile, users.status')
        ->join('roles', 'users.roles_id', '=', 'roles.id')
        ->orderBy("users.id","DESC")
        ->get();

        $roles = DB::table('permisos')
        ->where('rol_id','=', auth()->user()->roles_id)
        ->where('modulo_id','=', 1)
        ->where(function ($query) {
            $query->where('permiso', '=', 3)
                  ->orWhere('permiso', '=', 4);
        })
        ->get();

        $GLOBALS["editar"] = $roles[0]->permitido;
        $GLOBALS["eliminar"] = $roles[1]->permitido;

        return Datatables()->of($users)
        ->addIndexColumn()
        ->addColumn('avatar', function($users){

            $words = explode(" ", $users->name);
            
            $name = '';
            foreach ($words as $w) {
                $name .= $w . '+'; 
            }
            $avatar = '<img src="https://ui-avatars.com/api/?name='.$name.'&background=random" class="avatar-item rounded-circle responsive">';
        
            return $avatar;
        })
        ->addColumn('state', function($users){

            if($users->status == 1){
                $state = '<div class="badge bg-success-4 hp-bg-dark-success text-success border-success">Activo</div>';
            }
            if($users->status == 0){
                $state = '<div class="badge bg-danger-4 hp-bg-dark-danger text-danger border-danger">Inactivo</div>';
            }
        
            return $state;
        })
        ->addColumn('action', function($users){

            $btn = '<span style="display:inline-flex;vertical-align: middle;">';
            if($GLOBALS["editar"] == 1 || $GLOBALS["eliminar"] == 1){

                                if($GLOBALS["editar"] == 1){
                                    $btn .=  '<img src="'.url('img/edit-2.svg').'"  class="editar imgEdit toggle" id="'.$users->id.'" data-toggle="tooltip" data-placement="top" title="Editar" />';
                                }

                                if($GLOBALS["eliminar"] == 1){
                                    if($users->status == 1){
                                        $btn.='<input type="checkbox" id="switch_'.$users->id.'" /><label class="desactivar" id="lbl_'.$users->id.'" for="switch_'.$users->id.'"   data-toggle="tooltip" data-placement="top" title="Inactivar">Toggle</label>';
                                    }
                                    if($users->status == 0){
                                        $btn.='<input type="checkbox" id="switch_'.$users->id.'" checked /><label class="activar" id="lbl_'.$users->id.'" for="switch_'.$users->id.'" data-toggle="tooltip" data-placement="top" title="Activar">Toggle</label>';
                                    }
                                }

                                $btn.=  '</span>';
            }
        
            return $btn;
        })
        ->rawColumns(['avatar','state','action'])
        ->make(true);    

        //return Datatables::of($users)->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showUsuarios()
    {
        $roles = DB::table('permisos')
        ->where('rol_id','=', auth()->user()->roles_id)
        ->where('modulo_id','=', 1)
        ->where(function ($query) {
            $query->where('permiso', '=', 1)
                  ->orWhere('permiso', '=', 2)
                  ->orWhere('permiso', '=', 5);
        })
        ->get();

        if($roles[0]->permitido == 1){
            $roles_det = DB::table('roles')->get();
            return view('user.index')->with(['roles'=>$roles,'roles_det'=>$roles_det]);
        }
        else{
            
            return redirect('/');
        }
        
    }

    public function profile()
    {

        $roles_det = DB::table('roles')->get();
        return view('user.profile')->with(['roles_det'=>$roles_det]);
        
    }

    public function store(UserStoreRequest $request)
    {   
        $password = $this->generateRandomString();

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($password);
        $user->roles_id = $request->rol;
        $user->phone = $request->phone;
        $user->status = 1;
        
        if($user->save()){
            
            $men = $this->sendWelcome($request->name, $request->email, $password);
            return "1";
        }
        else{
            return "0";
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::findOrFail($id);

        $roles = DB::table('roles')->get();

        $profile = '';
        /*if(auth()->user()->profile_id == 1){
            $profile = '<option value="0">Selecciona un perfil</option>';
        }*/

        foreach($roles as $r){

            //if(auth()->user()->profile_id == 1){
                $profile .= '<option value="'.$r->id.'" ';
                
                if ($r->id == $user->roles_id) $profile .= 'selected';
                
                $profile .= '>'.$r->rol.'</option>';
            //}

            /*if(auth()->user()->profile_id == 2){
                if($r->id == 2){
                    $profile .= '<option value="'.$r->id.'" ';
                    
                    if ($r->id == $user->profile_id) $profile .= 'selected';
                    
                    $profile .= '>'.$r->name.'</option>';
                }
            }*/
        }
        $user->roles = $profile;

        return response()->json(
            $user
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserUpdateRequest $request, $id)
    {   
        
        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->roles_id = $request->rol;
        $user->phone = $request->phone;

        if(trim($request->password) != ''){
            $user->password = Hash::make($request->password);
        }

        if($user->update()){
            return "1";
        }
        else{
            return "0";
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $user = User::findOrFail($id);

            if($user->status == 1){
                $user->status = 0;
            }
            else{
                $user->status = 1;
            }
            

            if($user->update()){
                echo "1";
            }
            else{
                echo "0";            
            }
        }
        catch(Exception $e){
            Log::error($e);
            echo "0";
        }
    }

    public function showLogin(){
        if(Auth::check()){  return redirect('/'); }
        $intentos = Parametro::select('valor')->where('nombre','=',"LOGIN_INTENTO")->first();
        $tiempo = Parametro::select('valor')->where('nombre','=',"LIMITE_TIEMPO_LOGIN")->first();
        return view('autenticacion.login')->with(['intentos'=>$intentos,'tiempo'=>$tiempo]);
    }

    public function showForgotForm(){
        return view('autenticacion.recover');
    }

    public function sendResetLink(Request $request){
        $request->validate([
            'email'=>'required|email|exists:users,email'
        ]);

        $user = User::where('email', $request->email)->first();
        $request->name_user = $user->name;

        $token = \Str::random(64);
        DB::table('password_resets')->insert([
              'email'=>$request->email,
              'token'=>$token,
              'created_at'=>Carbon::now(),
        ]);
        
        $action_link = route('reset.password.form',['token'=>$token,'email'=>$request->email]);
        $base_url = route('show.login');

        $body = "Recibimos tu petición para restablecer la contraseña en <b>".env('APP_NAME')."</b> asociado con el correo ".$request->email.". Tu puedes restablecer la contraseña al presionar el botón abajo";
    
        $email = $request->email;
        $name_user = $request->name_user;

        return $this->sendEmailResetLink($base_url, $action_link, $body, $email, $name_user);

   }

   public function showResetForm(Request $request, $token = null){
       
       $check_token = \DB::table('password_resets')->where([
            'email'=>$request->email,
            'token'=>$request->token,
       ])->first();

       if(!$check_token){
            return redirect()->route('login');
       }
    
       return view('autenticacion.reset')->with(['token'=>$request->token,'email'=>$request->email]);
   }

   public function resetPassword(UserResetPasswordRequest $request){

       $check_token = \DB::table('password_resets')->where([
           'email'=>$request->email,
           'token'=>$request->token,
       ])->first();

       if(!$check_token){
           return 0;
       }else{

           User::where('email', $request->email)->update([
               'password'=>\Hash::make($request->password)
           ]);

           $user = User::where('email', $request->email)->first();

           /*$notification = new Notification();
           $notification->catalogue_notifications_id = 2;
           $notification->date = date('Y-m-d H:i:s');
           $notification->users_id = $user->id;
           $notification->franchise_id = $user->franchise_id;
           $notification->save();

           event(new NotificationEvent("2",$user->franchise_id));

           if($user->profile_id == 2){
            event(new NotificationFranchiseEvent("2",$user->franchise_id));
           }*/

           \DB::table('password_resets')->where([
               'email'=>$request->email
           ])->delete();

           return 1;
       }
   }

    public function generateRandomString($length = 12) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ@$!%*?&._-';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
