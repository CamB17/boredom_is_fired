<? 
//this was brought straight in from graceland, needs work
class bif_base_post {
    
    protected $post_id;
    protected $title;
    protected $permalink;
    protected $image_array;
    protected $category;
    protected $formatted_date;
    protected $content;
    
    
    const POST_TYPE = "none";
    
    /*
    $post_id: required to be an integer
    */
    public function __construct($post_id) {
        
        
        
        if ( $post_id && is_int($post_id) ) {
            
            $post_type = get_post_type($post_id);
            
            if ( static::POST_TYPE == $post_type ) {
                $this->post_id = $post_id;
            } else {
                trigger_error("'" . static::POST_TYPE . "' post type required, '" . $post_type . "' post type given.", E_USER_ERROR);
            }
            
            
        } else {
            trigger_error('post_id required to be integer', E_USER_ERROR);
        }
        
        $this->title = get_the_title($this->post_id);
        $this->image_array = get_field('image', $this->post_id);
        $this->formatted_date = get_the_date('F jS, Y', $this->post_id);
        $this->category = get_the_terms($this->post_id, 'category');
        $this->permalink = get_the_permalink($this->post_id);
        $this->content = apply_filters('the_content', get_post_field('post_content', $this->post_id));
        

        // $this->category_list = get_the_category_list(', ', '', $this->post_id);

        
    }
    // helper function so you dont have to pass in the post id every time
    protected function gf($field_name) {
        return get_field($field_name, $this->post_id);
    }
    
    public function get_the_ID() {
        return $this->post_id ?? null;
    }
    public function get_the_permalink() {
        return $this->permalink;
    }
    public function get_the_title() {
        return $this->title ?? null;
    }
    public function get_image() {
        return $this->image_array;
    }
    public function get_image_id() {
        return $this->image_array['ID'];
    }
    public function get_image_url() {
        return $this->image_array['sizes']['large'] ?? null;
    }
    public function get_image_alt() {
        return $this->image_array['alt'] ?? null;
    }
    public function get_category() {
        return $this->category;
    }
    public function get_formatted_date() {
        return $this->formatted_date ?? null;
    }
    public function get_content() {
        return $this->content ?? null;
    }
    // public function get_category_list() {
    //     // return $this->category_list ?? null;
    //     return $this->category_list;
    //     // return implode(", ", array_column($this->category_list, "post_title"));
    // }
    
}
?>