<?php

namespace App\Modules\MLM\Managements\PassiveIncome\Actions;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Modules\MLM\Managements\PassiveIncome\Database\Models\PassiveIncomeStat;
use App\Modules\MLM\Managements\PassiveIncome\Database\Models\PassiveIncomeContent;
use App\Modules\MLM\Managements\PassiveIncome\Database\Models\CommissionRate;

class SavePassiveIncomeAction
{
    /**
     * Validate and persist stats and content.
     * @return array ['stat' => PassiveIncomeStat, 'content' => PassiveIncomeContent]
     */
    public function handle(Request $request, ?int $userId = null): array
    {
        $validated = Validator::make($request->all(), [
            'level_1_count' => 'required|integer|min:0',
            'level_2_count' => 'required|integer|min:0',
            'level_3_count' => 'required|integer|min:0',
            'level_4_count' => 'required|integer|min:0',
            'delivered_orders' => 'required|integer|min:0',
            'estimated_daily_commission' => 'required|numeric|min:0',
        ])->validate();

        // Stats: find by user or fallback to first
        $stat = null;
        if ($userId) {
            $stat = PassiveIncomeStat::where('user_id', $userId)->first();
        }

        if (! $stat) {
            $stat = PassiveIncomeStat::first();
        }

        if (! $stat) {
            $stat = new PassiveIncomeStat();
            $stat->user_id = $userId;
        }

        $stat->is_verified_seller = $request->has('is_verified_seller');
        $stat->level_1_count = (int) $validated['level_1_count'];
        $stat->level_2_count = (int) $validated['level_2_count'];
        $stat->level_3_count = (int) $validated['level_3_count'];
        $stat->level_4_count = (int) $validated['level_4_count'];
        $stat->delivered_orders = (int) $validated['delivered_orders'];
        $stat->estimated_daily_commission = (float) $validated['estimated_daily_commission'];
        $stat->save();

        // Content: first row or new
        $content = PassiveIncomeContent::first();
        if (! $content) {
            $content = new PassiveIncomeContent();
        }

        $content->header_title = $request->input('header_title', $content->header_title);
        $content->header_subtitle = $request->input('header_subtitle', $content->header_subtitle);
        $content->intro_text = $request->input('intro_text', $content->intro_text);
        $content->what_is_title = $request->input('what_is_title', $content->what_is_title);
        $content->what_is_text = $request->input('what_is_text', $content->what_is_text);
        $content->how_title = $request->input('how_title', $content->how_title);
        $content->how_text = $request->input('how_text', $content->how_text);
        $content->seller_code_title = $request->input('seller_code_title', $content->seller_code_title);
        $content->seller_code_text = $request->input('seller_code_text', $content->seller_code_text);
        $content->why_title = $request->input('why_title', $content->why_title);
        $content->why_text = $request->input('why_text', $content->why_text);
        $content->commission_title = $request->input('commission_title', $content->commission_title);
        $content->commission_table_html = $request->input('commission_table_html', $content->commission_table_html);
        $content->conclusion_text = $request->input('conclusion_text', $content->conclusion_text);
        $content->terms_title = $request->input('terms_title', $content->terms_title);
        $content->terms_html = $request->input('terms_html', $content->terms_html);
        $content->save();

        // Save commission rates (if provided)
        if ($request->has('commission_rates')) {
            $rates = $request->input('commission_rates', []);

            // Delete existing rates
            CommissionRate::truncate();

            // Create new rates
            foreach ($rates as $index => $rate) {
                if (!empty($rate['min_price']) && !empty($rate['max_price'])) {
                    CommissionRate::create([
                        'min_price' => $rate['min_price'],
                        'max_price' => $rate['max_price'],
                        'level_1_commission' => $rate['level_1_commission'] ?? 0,
                        'level_2_commission' => $rate['level_2_commission'] ?? 0,
                        'level_3_commission' => $rate['level_3_commission'] ?? 0,
                        'level_4_commission' => $rate['level_4_commission'] ?? 0,
                        'sort_order' => $index + 1,
                    ]);
                }
            }
        }

        return ['stat' => $stat, 'content' => $content];
    }
}
