<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Task;
use GenTux\Jwt\JwtToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

/**
 * Class TasksController
 *
 * @package App\Http\Controllers\v1
 */
class TasksController extends Controller
{

    /**
     * Get logged user
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function get($id)
    {
		 try {
			 
			 
			$task = Task::find($id);
	   
	     return $this->returnSuccess($task);
        } catch (\Exception $e) {
            return $this->returnError($e->getMessage());
        }
    }

    /**
     * Update logged user
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function add(Request $request)
    {
        try {
			
			$rules = [
				'name' => 'required',
                'description' => 'required',
                'status' => 'required',
                'user_id' => 'required',
				'assign' => 'required',
            ];

            $validator = Validator::make($request->all(), $rules);

            if (!$validator->passes()) {
                return $this->returnBadRequest('Please fill all required fields');
            }
			
			$task = new Task();
            $task->name = $request->name;
            $task->description = $request->description;
            $task->status = $request->status;
            $task->user_id = $request->user_id;
            $task->assign = $request->assign;

            $task->save();
            return $this->returnSuccess($task);
        } catch (\Exception $e) {
            return $this->returnError($e->getMessage());
        }
    }
	
	
	 /**
     * Retrage toti utilizatorii din baza de date
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAll()
    {
      try {
			$task = Task::all();
	   
	     return $this->returnSuccess($task);
        } catch (\Exception $e) {
            return $this->returnError($e->getMessage());
        }
    }
	
	
	public function deleteTask($id)
	{
		try {
            $task = Task::find($id);

            $task->delete();

            return $this->returnSuccess();
        } catch (\Exception $e) {
            return $this->returnError($e->getMessage());
        }
	}
	
	public function editTask(Request $request, $id)
	{
		 try {
            $task = Task::find($id);

            if ($request->has('name')) {
                $task->name = $request->name;
            }

            if ($request->has('description')) {
                $task->description = $request->description;
            }

            if ($request->has('status')) {
                $task->status = $request->status;
            }

            if ($request->has('assign')) {
                $task->assign = $request->assign;
            }

            $task->save();

            return $this->returnSuccess($task);
        } catch (\Exception $e) {
            return $this->returnError($e->getMessage());
        }
	}
	
}