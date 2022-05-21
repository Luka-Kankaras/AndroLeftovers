<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StaticFieldRequest extends FormRequest {

    public function authorize() : bool {
        return true;
    }

    public function rules() : array {
        return [
            'order_yours' => 'required|min:2|max:100',
            'toothbrush_toothpaste' => 'required|min:2|max:100',
            'view_all_products' => 'required|min:2|max:100',
            'text_1' => 'required|min:2|max:300',
            'text_1_description' => 'required|min:2|max:300',
            'text_2' => 'required|min:2|max:300',
            'text_2_description' => 'required|min:2|max:300',
            'text_3' => 'required|min:2|max:300',
            'text_3_description' => 'required|min:2|max:300',
            'text_4' => 'required|min:2|max:300',
            'text_4_description' => 'required|min:2|max:300',
            'our_exclusive_features' => 'required|min:2|max:100',
            'always_at_hand' => 'required|min:2|max:100',
            'perfect_for_outdoors' => 'required|min:2|max:100',
            'expert_construction' => 'required|min:2|max:100',
            'airplane_friendly' => 'required|min:2|max:100',
            'brush_your_teeth_anytime' => 'required|min:2|max:100',
            'ivmax' => 'required|min:2|max:100',
            'anatomy' => 'required|min:2|max:100',
            'subscribe_annual' => 'required|min:2|max:100',
            'and_save' => 'required|min:2|max:100',
            'learn_more' => 'required|min:2|max:100',
            'what_our_clients_say' => 'required|min:2|max:100',
            'testimonials' => 'required|min:2|max:100',
            'find_your' => 'required|min:2|max:100',
            'style' => 'required|min:2|max:100',
            'five_unique_colors' => 'required|min:2|max:100',
            'which_one_goes_with_your_character' => 'required|min:2|max:100',

            'products_title' => 'required|min:2|max:100',
            'pack_include' => 'required|min:2|max:100',
            'available_brush_heads' => 'required|min:2|max:100',
            'buy' => 'required|min:2|max:100',
            'create_your_pack' => 'required|min:2|max:100',
            'our_team' => 'required|min:2|max:100',
            'blog' => 'required|min:2|max:100',
            'similar_blogs' => 'required|min:2|max:100',
            'share' => 'required|min:2|max:100',
            'general_info' => 'required|min:2|max:100',
            'faq' => 'required|min:2|max:100',
            'contact_support' => 'required|min:2|max:100',
            'full_name' => 'required|min:2|max:100',
            'message' => 'required|min:2|max:100',
            'send' => 'required|min:2|max:100',
            'products' => 'required|min:2|max:100',
            'about' => 'required|min:2|max:100',
            'help' => 'required|min:2|max:100',
            'shop' => 'required|min:2|max:100',
            'form_successful_submit' => 'required|min:2|max:100',
            'every_3_months_or_yearly' => 'required|min:2|max:100',
            'error_404' => 'required|min:2|max:100',
            'error_500' => 'required|min:2|max:100',
            'not_found' => 'required|min:2|max:100',
            'internal_server_error' => 'required|min:2|max:100',
            'ivmax_toothbrush' => 'required|min:2|max:100',
            'brush_head' => 'required|min:2|max:100',
            'toothpaste_cartridges' => 'required|min:2|max:100',
            'all_in_one_toothbrush_solution' => 'required|min:2|max:100',
            'who_we_are' => 'required|min:2|max:100',
            'footer_successful_submit' => 'required|min:2|max:100',
            'subscribe_newsletter' => 'required|min:2|max:100',
            'terms_and_conditions' => 'required|min:2|max:100',
            'privacy_policy' => 'required|min:2|max:100',
        ];
    }
}
