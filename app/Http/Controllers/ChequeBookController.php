<?php

namespace App\Http\Controllers\Api\V1;

use App\Actions\Identifier;
use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\ChequeBook\CreateRequest;
use App\Http\Requests\ChequeBook\UpdateRequest;
use App\Http\Requests\ChequeBook\UpdateStatusRequest;
use App\Http\Resources\ChequeBook\ChequeBookResource;
use App\Http\Resources\ChequeBook\ChequeBookResourcesCollection;
use App\Services\ChequeBookService;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class ChequeBookController extends ApiController
{

    public function __init__(){
        $this->service = new ChequeBookService();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $this->authorized('index')->setMessage();
            $chequeBooks = $this->service->index(
                [
                    "filters"    =>  $request->query() ? Arr::only($request->query(), ['search','trashed']) : []
                ],
                true,
                50,
                $request->query("page")
            );
            return $this->respond(new ChequeBookResourcesCollection($chequeBooks));
        } catch (\Exception $exception) {
            return $this->exceptionRespond($exception);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\CreateRequest  $request
     * @return \Illuminate\Http\Response
     */

    public function store(CreateRequest $request)
    {
        try {
            return $this->authorized("store")->setMessage()
                ->respond($this->dispatchService->store($request->all()));
        } catch (\Exception $exception) {
            return $this->exceptionRespond($exception);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
   public function show(Identifier $chequeBook, $filters = [])
    {
        try {
            $this->authorized('show')->setMessage();
            return $this->respond(new ChequeBookResource($this->service->show($chequeBook)));
        } catch (\Exception $exception) {
            return $this->exceptionRespond($exception);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, Identifier $chequeBook)
    {
        try {
            return $this->authorized("update")->setMessage()
                ->respond(new ChequeBookResource($this->dispatchService->update($chequeBook, $request->all())));
        } catch (\Exception $exception) {
            return $this->exceptionRespond($exception);
        }
    }

    
    /**
     * statusUpdate
     *
     * @param  mixed $request
     * @param  mixed $admin
     * @return void
     */
    public function statusUpdate(UpdateStatusRequest $request, Identifier $id)
    {

        try {
            return $this->authorized("update")->setMessage()
                ->respond($this->dispatchService->updateStatus($id, $request->all()));
        } catch (\Exception $exception) {
            return $this->exceptionRespond($exception);
        }
    }
}
