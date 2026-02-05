<?php

namespace App\Modules\MLM\Managements\PassiveIncome\Actions;

use Illuminate\Http\Request;
use App\Modules\MLM\Managements\PassiveIncome\Database\Models\PassiveIncomeStat;
use App\Modules\MLM\Managements\PassiveIncome\Database\Models\PassiveIncomeContent;
use App\Modules\MLM\Managements\PassiveIncome\Database\Models\CommissionRate;

class Index
{
    /**
     * Load stats and content for the Passive Income page.
     * Returns an array: ['stat' => PassiveIncomeStat, 'content' => PassiveIncomeContent, 'edit' => bool]
     */
    public function handle(Request $request)
    {
        // Try to fetch stat for authenticated user, otherwise load a demo/global stat
        $userId = auth()->check() ? auth()->id() : null;

        $stat = null;
        if ($userId) {
            $stat = PassiveIncomeStat::where('user_id', $userId)->first();
        }

        if (! $stat) {
            $stat = PassiveIncomeStat::first();
        }

        // If no stat in DB, create a default demo record
        if (! $stat) {
            $stat = PassiveIncomeStat::create([
                'user_id' => $userId,
                'is_verified_seller' => false,
                'level_1_count' => 0,
                'level_2_count' => 0,
                'level_3_count' => 0,
                'level_4_count' => 0,
                'delivered_orders' => 0,
                'estimated_daily_commission' => 0.00,
            ]);
        }

        // Load editable page content (create defaults if missing)
        $content = PassiveIncomeContent::first();
        if (! $content) {
            $content = PassiveIncomeContent::create([
                'header_title' => 'Passive Income Generate',
                'header_subtitle' => 'প্যাসিভ ইনকাম - কোন প্রকার পুঁজি বা ইনভেস্টমেন্ট ছাড়াই সেলস টিম গঠন করে প্রফিট অর্জন করুন।',
                'intro_text' => 'আপনার তত্ত্বাবধায়নে একটা সেলস টিম তাদের নিজেদের প্রফিট অর্জনের জন্য সেল করবে, যার উপর আপনি একটা সেলস কমিশন পেতে থাকবেন। এবং আপনার অবর্তমানেও সেই ইনকাম অব্যাহত থাকবে।',
                'what_is_title' => 'প্যাসিভ ইনকাম কি?',
                'what_is_text' => 'আপনার তত্ত্বাবধায়নে একটা সেলস টিম তাদের নিজেদের প্রফিট অর্জনের জন্য সেল করবে, যার উপর আপনি একটা সেলস কমিশন পেতে থাকবেন। এবং আপনার অবর্তমানেও সেই ইনকাম অব্যাহত থাকবে।',
                'how_title' => 'কিভাবে প্যাসিভ ইনকাম করবেন?',
                'how_text' => 'বিনা পুঁজিতে স্মার্ট ইনকাম হিসেবে রিসেলিং বিজনেসে সবাই আগ্রহী হচ্ছে। আপনি শুধু এই সকল আগ্রহী সেলারদের আপনার সেলার কোড ব্যবহার করিয়ে অ্যাপসে রেজিস্ট্রেশন করিয়ে, একজন লিডার হিসেবে তাদের প্রাথমিক পর্যায়ে সেলস সম্পর্কিত কিছু বিষয়ে সাপোর্ট দিবেন। শুরু হয়ে যাবে আপনার প্যাসিভ ইনকাম।',
                'seller_code_title' => 'সেলার কোড কি এবং কিভাবে পাবেন ?',
                'seller_code_text' => 'আপনার একাউন্ট থেকে ১০ টি অর্ডার সম্পূর্ণভাবে ডেলিভারি হওয়ার পর আপনি হয়ে যাবেন শপবেইজ বিডির একজন ভেরিফাইড সেলার। ভেরিফাইড সেলার হওয়ার সাথে সাথে আপনি একটা সেলার কোড পেয়ে যাবেন।',
                'why_title' => 'কেন আপনি প্যাসিভ ইনকাম টি বেছে নিবেন?',
                'why_text' => 'স্বাধীন এবং সম্পূর্ণ বৈধ ইনকাম হিসেবে রিসেলিং বিজনেসটি ব্যাপক জনপ্রিয়তা অর্জন করতে যাচ্ছে।',
                'commission_title' => 'সেলস কমিশন রেট',
                'commission_table_html' => null,
                'conclusion_text' => 'আপনি একটু পরিশ্রমের মাদ্ধমে ৫০ জন একটিভ সেলার অ্যাড করতে পারলে প্রতিদিন আপনি অ্যাভারেজ ২০০ - ২৫০ টাকা পর্যন্ত সেলস কমিশন অটো পেতে থাকবেন।',
                'terms_title' => 'অ্যামেজিং ফ্যামিলি হাবর নীতি ও শর্তাবলী',
                'terms_html' => null,
            ]);
        }

        $edit = $request->query('edit') == '1';

        // Load commission rates
        $commissionRates = CommissionRate::orderBy('sort_order')->get();

        return ['stat' => $stat, 'content' => $content, 'edit' => $edit, 'commissionRates' => $commissionRates];
    }
}
