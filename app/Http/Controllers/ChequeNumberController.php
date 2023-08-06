<?php

namespace App\Http\Controllers\Api\V1;

use App\Actions\Identifier;
use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\ChequeNumber\CreateRequest;
use App\Http\Requests\ChequeNumber\UpdateRequest;
use App\Http\Requests\ChequeNumber\UpdateStatusRequest;
use App\Http\Resources\ChequeNumber\ChequeNumberResource;
use App\Http\Resources\ChequeNumber\ChequeNumberResourcesCollection;
use App\Services\ChequeNumberService;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class ChequeNumberController extends ApiController
{

    public function __init__(){
        $this->service = new ChequeNumberService();
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
            $chequeNumbers = $this->service->index(
                [
                    "filters"    =>  $request->query() ? Arr::only($request->query(), ['search','trashed']) : []
                ],
                true,
                50,
                $request->query("page")
            );
            return $this->respond(new ChequeNumberResourcesCollection($chequeNumbers));
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
   public function show(Identifier $chequeNumber, $filters = [])
    {
        try {
            $this->authorized('show')->setMessage();
            return $this->respond(new ChequeNumberResource($this->service->show($chequeNumber)));
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
    public function update(UpdateRequest $request, Identifier $chequeNumber)
    {
        try {
            return $this->authorized("update")->setMessage()
                ->respond(new ChequeNumberResource($this->dispatchService->update($chequeNumber, $request->all())));
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
