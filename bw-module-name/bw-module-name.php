<?php

/**
 * @class BWModuleName
 *
 */
class BWModuleName extends BeaverWarriorFLModule {

    /**
     * The taxonomy for post categories
     */
    const POST_TAXONOMY_CATEGORY = 'team_category';

    /**
     * Parent class constructor.
     * @method __construct
     */
    public function __construct(){
        FLBuilderModule::__construct(
            array(
                'name'            => __('BWModule Name', 'fl-builder'),  // your name custom module name
                'description'     => __('Description.', 'fl-builder'),   // description
                'category'        => __('Posts', 'skeleton-warrior'),    // chose category Posts, Spacestation etc
                'dir'             => $this->getModuleDirectory( __DIR__ ),
                'url'             => $this->getModuleDirectoryURI( __DIR__ ),
                'editor_export'   => true,
                'enabled'         => true,
                'partial_refresh' => true
            )
        );
    }

    /**
     * Method to retrieve the posts for the module.
     *
     * @return array An array of posts
     */
    public function getPosts(){

        $settings = $this->settings;
        $settings->posts_per_page = -1;

        $query  = FLBuilderLoop::query( $settings );

        $taxonomies       = FLBuilderLoop::taxonomies( $slug );
        $taxonomies_array = array();

        if ( count( $taxonomies ) > 0 ) {
            $taxonomies_array[-1] = __( 'No Filter', 'uabb' );
        }

        foreach ( $taxonomies as $tax_slug => $tax ) { // 
            $taxonomies_array[ $tax_slug ] = $tax->label;
        }

        return isset( $query->posts ) ? $query->posts : array();
    } 

    public function getPostCategoryString( $post_id ){
        // Make an array for our post terms
        $post_categories_array = array();
        // Get the categories
        $post_categories = wp_get_post_terms( $post_id, self::POST_TAXONOMY_CATEGORY );
        // Add all categories to the stored array
        for ( $i=0; $i<count($post_categories); $i++ ){
            array_push(
                $post_categories_array,
                $post_categories[$i]->name
            );
        }
        // Return a string version of the categories
        return implode(', ', $post_categories_array );
    }

    /**
     * Method to get the excerpt based on the set number of words in this module.
     *
     * @param  string $post_content The post content to truncate
     * @param  int $post_id The post ID
     *
     * @return string               The truncated content
     */
    public function getPostExcerpt( $post_content, $post_id ){
        // If we have an excerpt, use that instead
        if ( has_excerpt( $post_id ) ){
            return get_the_excerpt( $post_id );
        }
        // Otherwise, return truncated content
        else {
            return wp_trim_words( $post_content, $this->settings->except_word_length );
        }
    } 
}

FLBuilder::register_module(
    'BWMeetTheTeam', array(
        'general' => array(
            'title' => __( 'General', 'fl-builder'),
            'sections' => array(
                'general' => array(
                    'fields' => array(
                        'heading' => array(
                            'type'        => 'text',
                            'label'       => __( 'Section Title', 'fl-builder' ),
                        ),
                        'cta_text' => array(
                            'type'        => 'text',
                            'label'       => __( 'Call to Action Text', 'fl-builder' ),
                        ) 
                    ),
                ),
            ) 
        )  
    ) 
);
