<?php

namespace App\Http\Controllers;

use App\Http\Requests\QuoteRequest;
use App\Http\Requests\UpdateQuoteRequest;
use App\Http\Resources\QuoteResource;
use App\Models\Quote;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class QuoteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Quote::all();
        return response()->json([
            'message' => 'success',
            'data' => $data,
        ]);

        // paginate pake resource
        // return QuoteResource::collection(Quote::all());
        // return QuoteResource::collection(Quote::paginate(5));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(QuoteRequest $request)
    {
        $data = Quote::create($request->validated());
        return response()->json([
            'message' => 'success',
            'data' => $data,
        ]);

        // pake resource
        // $data = Quote::create($request->validated());
        // return new QuoteResource($data);
        // OR
        // if ($validated) :
            // $data = Quote::create($validated);
            // return new QuoteResource($data);
        // endif;
    }

    /**
     * Display the specified resource.
     */
    public function show(Quote $quote)
    {
        // $data = Quote::where('id', $id)->first();
        return response()->json([
            'message' => 'success',
            'data' => $quote,
        ]);
        // if ($quote) {
        //     return response()->json($quote);
        // } else {
        //     return response()->json(["message" => "nothing data"], 404);
        // }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Quote $quote)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateQuoteRequest $request, Quote $quote)
    {
        // 1st model binding
        $quote->update($request->all());
        return new QuoteResource($quote);

        // 2nd pake model binding ($quote) + resource
        // return new QuoteResource(tap($quote)->update($request->validated()));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Quote $quote)
    {
        // 1st by $id
        // $quote = Quote::find($id);
        // if ($quote) {
        //     $quote->delete();
        //     return response()->json(['message' => 'success!']);
        // } else {
        //     return response()->json(['message' => 'error!']);
        // }

        // 2nd by model binding ($quote)
        $quote->delete();
        return response()->json(["message" => "success!"]);
        // return response()->noContent(); / null
    }
}
