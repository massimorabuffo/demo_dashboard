<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserList;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard.index');
    }

    public function getUserList(Request $request)
    {
        try{
            $userList = \App\Models\UserList::all();
    
            return view('pages.tables', [
                'userList' => $userList,
            ]);

        }catch (\Exception $e) {
        
            return response()->json([
                'status' => false,
                'message' => $e,
            ]);
        }
    }

    public function getUserList2(Request $request)
    {
        $userList = \App\Models\UserList::all();

        return response()->json($userList);
    }

    public function addUserPost(Request $request) {
        // var_dump($request->all()); die();
        // return response()->json($request->all());
        {
            // Controllo di un campo dati nel backend, commentato perché il controllo è stato aggiunto nel front end

            // if (is_null($request->function)) {
            //     return response()->json([
            //         'status' => false,
            //         'message' => 'Il campo function è obbligatorio.',
            //     ]);
            // }
     
            try {
                $user = new UserList;
        
                $user->author = $request->author;
                $user->function = $request->function;
                $user->status = $request->status;
                $user->employed = $request->employed;
                
                $saved = $user->save();

                if ($saved) {
                    return response()->json([
                        'status' => true,
                    ]);
                } else {
                    return response()->json([
                        'status' => false,
                        'message' => 'Si è verificato un errore imprevisto.',
                    ]);
                }
            } catch (\Exception $e) {
                if (str_contains($e->getMessage(), "Invalid datetime format")) { 
                    $message = "Formato data invalido. Inserisci la data nel seguente formato: 'yyyy-mm-dd'.";
                } else if (str_contains($e->getMessage(), "Duplicate entry")) {
                    $message = "Utente già registrato.";
                }
                return response()->json([
                    'status' => false,
                    'message' => $message,
                ]);
            }
     
            //return response()->json($request->all());
            
        }
    }
}
