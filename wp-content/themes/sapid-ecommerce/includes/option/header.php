<?php

// Do not allow directly accessing this file.
if (!defined("ABSPATH")) {
    exit("Direct script access denied.");
}

function sapid_options_section_header($sections){
    $has_global_content = "";
    $choices = [];
    $args = [
        "public" => true,
    ];
    $post_types = get_post_types($args, "objects");
    unset($post_types["attachment"]);
    unset($post_types["e-landing-page"]);
    unset($post_types["elementor_library"]);
    $choices['any'] = 'Any';
    foreach ($post_types as $post_type) {
        $choices[$post_type->name] = $post_type->labels->singular_name;
    }

    $sections["header"] = [
        "label" => esc_html__("Header", "Sapid"),
        "id" => "heading_header",
        "is_panel" => true,
        "priority" => 3,
        "icon" => "arrow-up-bold",
        "fields" => [],
    ];

    $sections["header"]["fields"] = [
        "header_logo" => [
            "label" => esc_html__("Header Logo", "Sapid"),
            "description" => "",
            "id" => "header_styling",
            "default" => "",
            "icon" => true,
            "type" => "sub-section",
            "fields" => [
                "logo_custom_link" => [
                    "label" => esc_html__("Logo Custom Link URL", "Sapid"),
                    "description" => esc_html__(
                        "Insert a custom URL from which the logo should be linked. Leave it blank to allow the logo to link to the home page.",
                        "Sapid"
                    ),
                    "id" => "logo-custom-link",
                    "default" => "",
                    "type" => "text",
                ],
                "logo" => [
                    "label" => esc_html__("Default Logo", "Sapid"),
                    "description" => esc_html__(
                        "You can choose any size for your logo, but we recommended you to choose a image size of 200x30px.",
                        "Sapid"
                    ),
                    "id" => "logo",
                    "default" => "/assets/images/logo.png",
                    "mod" => "min",
                    "type" => "media",
                ],
                'logo-retina' => [
                    'label'           => esc_html__( 'Retina Default Logo', 'Sapid' ),
                    'description'     => esc_html__( 'Upload an image for the retina version of the logo. The size of this logo should be exactly twice as big as the main logo.', 'Sapid' ),
                    'id'              => 'logo-retina',
                    'default'         => '/assets/images/logo@2x.png',
                    'mod'             => 'min',
                    'type'            => 'media',
                ],
                "fav_icon" => [
                    "label" => esc_html__("Favicon", "Sapid"),
                    "description" => esc_html__(
                        "Set favicon size for your website at 32px x 32px or 64px x 64px.",
                        "Sapid"
                    ),
                    "id" => "fav-icon",
                    "default" => "",
                    "type" => "media",
                ],
            ],
        ],
        "header_info_1" => [
            "label" => esc_html__("Header Content", "Sapid"),
            "description" => "",
            "id" => "header_info_1",
            "default" => "",
            "icon" => true,
            "type" => "sub-section",
            "fields" => [
                "header_number" => [
                    "label" => esc_html__(
                        "Phone Number For Contact Info",
                        "Sapid"
                    ),
                    "description" => esc_html__(
                        'Change your "Phone Number" for all pages at once from here.',
                        "Sapid"
                    ),
                    "id" => "header-number",
                    "default" => "9876543210",
                    "type" => "text",
                ],
                "header_email" => [
                    "label" => esc_html__(
                        "Email Address To Get Contact Info",
                        "Sapid"
                    ),
                    "description" => esc_html__(
                        'Change your "Email Address" for all pages at once from here.',
                        "Sapid"
                    ),
                    "id" => "header-email",
                    "default" => "info@yourdomain.com",
                    "type" => "text",
                ],
                "header_timing" => [
                    "label" => esc_html__("Timing For Contact", "Sapid"),
                    "description" => esc_html__(
                        'Change your "Contact Time" for all pages at once from here.',
                        "Sapid"
                    ),
                    "id" => "header-timing",
                    "default" => "8.00 AM - 6:00PM",
                    "type" => "text",
                ],
                "header_address" => [
                    "label" => esc_html__(
                        "Address To Get Contact Info",
                        "Sapid"
                    ),
                    "description" => esc_html__(
                        "Change your “Address information” for all pages at once from here.",
                        "Sapid"
                    ),
                    "id" => "header-address",
                    "default" => "Insert Address",
                    "type" => "textarea",
                ],
            ],
        ],
        "sticky_header" => [
            "label" => esc_html__("Header Sticky", "Sapid"),
            "description" => "",
            "id" => "sticky-header",
            "default" => "",
            "icon" => true,
            "type" => "sub-section",
            "fields" => [
                "header_sticky" => [
                    "label" => esc_html__("Sticky Header", "Sapid"),
                    "description" => esc_html__(
                        "To enable a stick header, turn it on.",
                        "Sapid"
                    ),
                    "id" => "header-sticky",
                    "default" => 1,
                    "type" => "switch",
                ],
            ],
        ],
        "search_page_option_section" => [
            "label" => esc_html__("Search Page", "Sapid"),
            "description" => "",
            "id" => "search_page_options_section",
            "icon" => true,
            "type" => "sub-section",
            "fields" => [
                "search_grid_columns" => [
                    "label" => esc_html__("Number of Columns", "Sapid"),
                    "description" => __(
                        "Manage the grid layouts for the number of columns",
                        "Sapid"
                    ),
                    "id" => "search-grid-columns",
                    "default" => 3,
                    "type" => "slider",
                    "class" => "fusion-or-gutter",
                    "choices" => [
                        "min" => 1,
                        "max" => 6,
                        "step" => 1,
                    ],
                ],
                "search_excerpt" => [
                    "label" => esc_html__("Search Excerpt Display", "Sapid"),
                    "description" => esc_html__(
                        "Controls whether or not the search excerpt text content is displayed on the search page.",
                        "Sapid"
                    ),
                    "id" => "search-excerpt",
                    "default" => "1",
                    "type" => "switch",
                ],
                "search_meta" => [
                    "label" => esc_html__("Search Results Meta", "Sapid"),
                    "description" => esc_html__(
                        "Enable the display of post meta.",
                        "Sapid"
                    ),
                    "id" => "search-meta",
                    "default" => "1",
                    "type" => "switch",
                ],
                "search_input" => [
                    "label" => esc_html__("Search Field", "Sapid"),
                    "description" => esc_html__(
                        "If you want to display search field turn it on",
                        "Sapid"
                    ),
                    "id" => "search-input",
                    "default" => "1",
                    "type" => "switch",
                    "data-mode" => "1",
                ],
            ],
        ],
        "search_form_options_section" => [
            "label" => esc_html__("Search Form", "Sapid"),
            "description" => "",
            "id" => "search-form-options-section",
            "icon" => true,
            "type" => "sub-section",
            "fields" => [
                "search_post_type" => [
                    "label" => esc_html__("Search Results Content", "Sapid"),
                    "description" => esc_html__(
                        "Controls the content that appears in search results.",
                        "Sapid"
                    ),
                    "id" => "search-post-type",
                    "default" => [
                        "post",
                    ],
                    "type" => "select",
                    "choices" => $choices,
                ],

                "search_limit_to_post_titles" => [
                    "label" => esc_html__(
                        "Limit Search to Post Titles",
                        "Sapid"
                    ),
                    "description" => esc_html__(
                        "Enable to limit the search to post titles only.",
                        "Sapid"
                    ),
                    "id" => "search-limit-to-post-titles",
                    "default" => "0",
                    "type" => "switch",
                ],
                "live_search" => [
                    "label" => esc_html__(
                        "Enable Auto Complete Search",
                        "Sapid"
                    ),
                    "description" => esc_html__(
                        "You can Auto complete search results on the menu search field and other fitting search forms by turning it on.",
                        "Sapid"
                    ),
                    "id" => "live-search",
                    "default" => "0",
                    "type" => "switch",
                ],
                "live_search_min_char_count" => [
                    "label" => esc_html__(
                        "Auto Complete Search Minimal Character Count",
                        "Sapid"
                    ),
                    "description" => esc_html__(
                        "Set the minimal character count to trigger the live search.",
                        "Sapid"
                    ),
                    "id" => "live-search-min-char-count",
                    "default" => "4",
                    "type" => "slider",
                    "choices" => [
                        "min" => "1",
                        "max" => "20",
                        "step" => "1",
                    ],
                    "data-parent" => "live-search",
                    "data-mode" => "1",
                ],
                "live_search_results_per_page" => [
                    "label" => esc_html__(
                        "Auto Complete Search Number of Posts",
                        "Sapid"
                    ),
                    "description" => esc_html__(
                        "Controls the number of posts that should be displayed as search result suggestions.",
                        "Sapid"
                    ),
                    "id" => "live-search-results-per-page",
                    "default" => "100",
                    "type" => "slider",
                    "choices" => [
                        "min" => "10",
                        "max" => "500",
                        "step" => "10",
                    ],
                    "data-parent" => "live-search",
                    "data-mode" => "1",
                ],
            ],
        ],
    ];

    return $sections;
}
