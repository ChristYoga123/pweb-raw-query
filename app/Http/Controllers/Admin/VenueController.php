<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Venue;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class VenueController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view("pages.admin.venue.index")->with([
            "venues" => DB::select("SELECT
            venues.name,
            venues.slug,
            venue_categories.name AS category_name,
            venues.price_per_night,
            venues.location,
            venues.hero_image
          FROM
            venues
          JOIN
            venue_categories ON venue_categories.id = venues.venue_category_id;")
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("pages.admin.venue.create")->with([
            "categories" => DB::select("SELECT * FROM venue_categories")
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "name" => "required|unique:venues,name",
            "venue_category_id" => "required|integer|exists:venue_categories,id",
            "price_per_night" => "required|integer",
            "location" => "required",
            "description" => "required",
            "hero_image" => "required|image|mimes:png,jpg,jpeg"
        ]);

        DB::beginTransaction();
        try {
            $hero_image = $request->file("hero_image")->store("venue-hero-image", "public");
            DB::insert("INSERT INTO venues(name, slug, venue_category_id, price_per_night, hero_image, location, description) VALUES(?, ?, ?, ?, ?, ?, ?)", [Str::title($request->name), Str::slug($request->name), $request->venue_category_id, $request->price_per_night, $hero_image, $request->location, $request->description]);
            DB::commit();
            return redirect()->route("admin.venue.index")->with("success", "Data berhasil disimpan");
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with("error", $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Venue $venue)
    {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Venue $venue)
    {
        $venue = DB::select("SELECT * FROM venues WHERE slug = ? LIMIT 1", [$venue->slug]);
        return view("pages.admin.venue.edit")->with([
            "venue" => $venue[0],
            "categories" => DB::select("SELECT * FROM venue_categories")
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Venue $venue)
    {
        $request->validate([
            "name" => "required|unique:venues,name," . $venue->id,
            "venue_category_id" => "required|integer|exists:venue_categories,id",
            "price_per_night" => "required|integer",
            "location" => "required",
            "description" => "required",
            "hero_image" => "image|mimes:png,jpg,jpeg"
        ]);

        DB::beginTransaction();
        try {
            if ($request->hasFile("hero_image")) {
                Storage::delete("public/" . $request->old_image);
                $new_hero_image = $request->file("hero_image")->store("venue-hero-image", "public");
            } else {
                $new_hero_image = $request->old_image;
            }
            DB::update("UPDATE venues SET name = ?, slug = ?, venue_category_id = ?, price_per_night = ?, location = ?, description = ?, hero_image = ?", [$request->name, Str::slug($request->name), $request->venue_category_id, $request->price_per_night, $request->location, $request->description, $new_hero_image]);
            DB::commit();
            return redirect()->route("admin.venue.index")->with("success", "Data berhasil diubah");
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with("error", $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Venue $venue)
    {
        DB::delete("DELETE FROM venue_galleries WHERE id = ?", [$venue->id]);
        DB::delete("DELETE FROM venues WHERE slug = ?", [$venue->slug]);
        return redirect()->back()->with("success", "Data berhasil dihapus");
    }
}
