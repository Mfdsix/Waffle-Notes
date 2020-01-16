<?php

namespace App\Http\Controllers;
use App\Note;

use Illuminate\Http\Request;
use Validator;

class NoteController extends Controller
{
	public function index($id = null){
		if($id == null || $id == ""){
			return response()->json([
				'status' => 400,
				'message' => 'Failed Get Data',
				'data' => null
			]);
		}else{
			$notes = Note::where('user_id', $id)
			->get();

			if(count($notes) == 0){
				return response()->json([
					'status' => 404,
					'message' => 'No Data Found',
					'data' => null
				]);
			}else{
				return response()->json([
					'status' => 200,
					'message' => 'Data Found',
					'data' => $notes->toArray()
				]);
			}
		}
	}

	public function store($id, Request $request){
		$validate = Validator::make($request->all(), [
			'title' => ['required', 'string', 'min:6'],
			'note' => ['required', 'string', 'min:10'],
		]);

		if($validate->fails()){
			return response()->json([
				'status' => 422,
				'message' => 'There is field that not Valid',
				'data' => null
			]);
		}else{
			$insert_note = Note::create([
				'title' => $request->title,
				'note' => $request->note,
				'user_id' => $id
			]);
			if($insert_note->id > 0){
				return response()->json([
					'status' => 200,
					'message' => 'Data Created',
					'data' => $insert_note->id
				]);
			}else{
				return response()->json([
					'status' => 400,
					'message' => 'Fail to Create Data',
					'data' => null
				]);
			}
		}
	}

	public function show($user_id = null, $id = null){
		if($id != null && $id != ""){
			$note = Note::find($id);

			if(empty($note)){
				return response()->json([
					'status' => 404,
					'message' => 'Note Not Found',
					'data' => null
				]);
			}else{
				return response()->json([
					'status' => 200,
					'message' => 'Data Found',
					'data' => $note
				]);
			}
		}else{
			return response()->json([
				'status' => 400,
				'message' => 'Failed Get Data',
				'data' => null
			]);
		}
	}

	public function update($user_id = null, $id = null, Request $request){
		if($id != null && $id != ""){
			$note = Note::find($id);

			if(empty($note)){
				return response()->json([
					'status' => 404,
					'message' => 'Note Not Found',
					'data' => null
				]);
			}else{
				$validate = Validator::make($request->all(), [
					'title' => ['required', 'string', 'min:6'],
					'note' => ['required', 'string', 'min:10'],
				]);

				if($validate->fails()){
					dd($validate->errors());
					return response()->json([
						'status' => 422,
						'message' => 'There is field that not Valid',
						'data' => null
					]);
				}else{
					$update_note = $note->update([
						'title' => $request->title,
						'note' => $request->note,
					]);
					return response()->json([
						'status' => 200,
						'message' => 'Note Updated',
						'data' => $id
					]);
				}
			}

		}else{
			return response()->json([
				'status' => 400,
				'message' => 'Failed Get Data',
				'data' => null
			]);
		}
	}

	public function destroy($user_id, $id = null){
		if($id != null && $id != ""){
			$note = Note::find($id);

			if(empty($note)){
				return response()->json([
					'status' => 404,
					'message' => 'Note Not Found',
					'data' => null
				]);
			}else{
				$delete_note = $note->delete();
				return response()->json([
					'status' => 200,
					'message' => 'Note Deleted',
					'data' => $id
				]);
			}
		}else{
			return response()->json([
				'status' => 400,
				'message' => 'Failed Get Data',
				'data' => null
			]);
		}
	}
}
