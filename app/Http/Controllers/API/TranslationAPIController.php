<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Models\Language;
use App\Models\Translation;
use Illuminate\Support\Facades\Cache;

class TranslationAPIController extends Controller
{

    /**
     * @OA\Get(
     *     path="/api/export",
     *     summary="Export translations as JSON for a specific locale",
     *     description="Returns all translations for the given locale in JSON format.",
     *     operationId="exportTranslations",
     *     tags={"Translations"},
     *     @OA\Parameter(
     *         name="locale",
     *         in="query",
     *         required=true,
     *         description="The locale of the translations to export (e.g., 'en', 'fr').",
     *         @OA\Schema(type="string", example="en")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful response with translations in JSON format",
     *         @OA\JsonContent(
     *             type="object",
     *             example={
     *                 "welcome_message": "Welcome",
     *                 "error_message": "An error occurred"
     *             }
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Locale not found",
     *         @OA\JsonContent(
     *             type="object",
     *             example={
     *                 "message": "Locale not found"
     *             }
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             type="object",
     *             example={
     *                 "message": "The given data was invalid.",
     *                 "errors": {
     *                     "locale": {
     *                         "The locale field is required."
     *                     }
     *                 }
     *             }
     *         )
     *     )
     * )
     */
    public function export(Request $request)
    {
        $request->validate(['locale' => 'required|string']);

        $locale = $request->input('locale');

        return Cache::remember("translations:{$locale}", 3600, function () use ($locale) {
            $language = Language::where('locale', $locale)->firstOrFail();

            return Translation::where('language_id', $language->id)
                ->get()
                ->pluck('value', 'key_name');
        });

    }

}
