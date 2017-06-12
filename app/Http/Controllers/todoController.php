<?php

namespace App\Http\Controllers;

use App\todo;
use Illuminate\Http\Request;

use App\Http\Requests;

class todoController extends Controller
{
    public function insert(Request $request){
        $this->validate($request, [
            'task' => 'required|max:255',
        ]);
        $todo = new todo($request->all());
        if($todo->save()){
            return response()->json([
                'message' => 'success',
                'id' => $todo->id,
                'task' => $todo->task
            ]);
        }else{
            return response()->json([
                'message' => 'fail'
            ]);
        }
    }

    public function delete(Request $request){
        //Delete 1 task
        if(isset($request->id)){
            $todo = todo::find($request->id);
            if($todo->delete()){
                return response()->json([
                    'message' => 'success',
                    'id' => $todo->id
                ]);
            }else{
                return response()->json([
                    'message' => 'fail'
                ]);
            }
        }
        //Jika delete >= 1 task
        else if(isset($request->ids)){
            $response = array();

            foreach($request->ids as $id){
                $todo = todo::find($id);
                if($todo->delete()){
                    array_push($response,$id);
                }
            }
            if(count($response) == count($request->ids)){
                return response()->json([
                    'message' => 'success',
                    'id' => $response
                ]);
            }else{
                return response()->json([
                    'message' => 'partial_success',
                    'id' => $response
                ]);
            }
        }

    }
}
