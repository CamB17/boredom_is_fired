<? 
//this was brought straight in from graceland, needs work
class bif_post extends bif_base_post {
    
    protected $metro;
    protected $city_state;
    protected $property;
    protected $division;
    protected $related_metro_id;
    protected $related_property_id;
    protected $feed_division;
    protected $link_name;
    protected $related_title;
    protected $related_link_name;
    protected $related_link_url;
    protected $hide_back_to_news;
    protected $pre_filter_archive;
    protected $used_filters;
    protected $filtered_category;
    protected $filtered_division;
    protected $filtered_property;
    protected $filtered_metro;
    
    const POST_TYPE = "post";
    
    /*
    $post_id: required to be an integer
    */
    public function __construct($post_id) {

    

        parent::__construct($post_id);


        $this->city_state = $this->gf('city_state');
        $this->type = $this->gf('type');
        $this->metro = $this->gf('post_metro');
        $this->related_metro_id = $this->gf('metro');
        $this->related_property_id = $this->gf('property');
        $this->related_title = $this->gf('title');
        $this->related_link_name = $this->gf('link_name');
        $this->related_link_url = $this->gf('link_url');
        $this->hide_back_to_news = $this->gf('hide_back_to_news');
        $this->pre_filter_archive = $this->gf('pre-filter_archive');
        $this->used_filters = $this->gf('used_filters');
        $this->filtered_category = $this->gf('filtered_category');
        $this->filtered_division = $this->gf('filtered_division');
        $this->filtered_property = $this->gf('filtered_property');
        $this->filtered_metro = $this->gf('filtered_metro');
        
        // if ( $this->metros ) {
        //     $metro = new bif_metro($metro_id);
        //     $this->metro_name = $metro->get_the_title();
        // }
        
        // $this->metro_wp_object = $this->gf('metros');
        $this->property = $this->gf('associated_property');
        $this->news_type = $this->gf('type');
        
        // feed info
        
        $this->feed_type = $this->gf('feed_type');
        $this->division = $this->gf('post_division');
        $this->feed_division = $this->gf('division');
        $this->manual_posts = $this->gf('manual_posts');
        $this->link_name = $this->gf('link_name');

        // $this->category_list = get_the_category_list(', ', '', $this->post_id);

        
    }
    
    
    // public function get_metro_name() {
    //     return $this->metro_name ?? null;
    // }
    
    public function get_feed_type() {
        return $this->feed_type;
    }
    public function get_link_name() {
        return $this->link_name;
    }
    public function get_manual_posts() {
        return $this->manual_posts;
    }
    public function get_filtered_metro() {
        return $this->filtered_metro ?? null;
    }
    public function get_filtered_category() {
        return $this->filtered_category ?? null;
    }
    public function get_filtered_property() {
        return $this->filtered_property ?? null;
    }
    public function get_filtered_division() {
        return $this->filtered_division ?? null;
    }
    public function get_pre_filter_archive() {
        return $this->pre_filter_archive ?? null;
    }
    public function get_used_filters() {
        return $this->used_filters ?? null;
    }
    public function get_news_type() {
        return $this->news_type ?? null;
    }
    public function get_metro_id() {
        return $this->metro->ID ?? null;
    }
    public function get_metro_arr() {
        return $this->metro ?? null;
    }
    public function get_hide_back_to_news() {
        return $this->hide_back_to_news ?? null;
    }
    public function get_related_metro_id() {
        return $this->related_metro_id ?? null;
    }
    public function get_related_property_id() {
        return $this->related_property_id ?? null;
    }
    public function get_related_title() {
        return $this->related_title ?: "Related Posts";
    }
    public function get_related_link_name() {
        return $this->related_link_name ?: "Recent News";
    }
    public function get_related_link_url() {
        return $this->related_link_url ?: "/news/";
    }
    public function get_metro_title() {
        return $this->metro->post_title ?? null;
    }
    public function get_market_permalink_by_metro() {
        if(isset($this->metro->ID)) {
            $market = new bif_metro($this->metro->ID);
            return $market->get_market_permalink();
        }
        return null;
    }
    public function get_metro_wp_object() {
        return $this->metro_wp_object ?? null;
    }
    public function get_property_wp_object() {
        return $this->property->post_title ?? null;
    }

    public function get_city_state() {
        return $this->city_state ?? null;
    }
    public function get_division() {
        return $this->division ?? null;
    }
    public function get_feed_division() {
        return $this->feed_division ?? null;
    }
    public function get_division_list_pretty() {
        if($this->division) {
            $div_arr = array();
            foreach ($this->division as $division) {
                array_push($div_arr, get_pretty_division($division));
            }
            return implode(", ", $div_arr);
        }
        return null;
    }
    public function get_associated_property_name() {
        return $this->property->post_title ?? null;
    }
    public function get_associated_property_permalink() {
        return get_the_permalink($this->property->ID) ?? null;
    }
    public function get_type() {
        return $this->type ?? null;
    }

    
}
?>