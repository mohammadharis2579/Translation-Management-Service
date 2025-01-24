<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Language;
use App\Models\Translation;
use Illuminate\Support\Facades\Cache;

class TranslationController extends Controller
{
    public function create(Request $request)
    {
        $request->validate([
            'key_name' => 'required|string|max:255',
            'value' => 'required|string',
            'locale' => 'required|string|max:10',
            'tags' => 'array'
        ]);

        $language = Language::firstOrCreate(['locale' => $request->locale]);

        $translation = Translation::create([
            'key_name' => $request->key_name,
            'value' => $request->value,
            'language_id' => $language->id,
            'tags' => json_encode($request->tags),
        ]);

        Cache::forget("translations:{$request->locale}");

        return response()->json($translation, 201);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'key_name' => 'required|string|max:255',
            'value' => 'required|string',
            'locale' => 'required|string|max:10',
            'tags' => 'array'
        ]);

        $language = Language::firstOrCreate(['locale' => $request->locale]);

        $translation = Translation::updateOrCreate([
            'key_name' => $request->key_name,
            'language_id' => $language->id,
        ],[
            'value' => $request->value,
            'tags' => json_encode($request->tags),
        ]);

        Cache::forget("translations:{$request->locale}");

        return response()->json($translation, 201);
    }

    public function search(Request $request)
    {
        $query = Translation::query();

        if ($request->has('key_name')) {
            $query->where('key_name', $request->key_name);
        }

        if ($request->has('tags')) {
            $query->whereJsonContains('tags', $request->tags);
        }

        if ($request->has('locale')) {
            $language = Language::where('locale', $request->locale)->first();
            if ($language) {
                $query->where('language_id', $language->id);
            }
        }

        return response()->json($query->get());
    }
}
