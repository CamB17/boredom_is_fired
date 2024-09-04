<? class bif_module_wrapper 
{
    
    public function __construct(
        // needs to match the module's function name
        private string $name,
        private string $background_color,
        // this is the type of element the module will be wrapped in
        private string $element = "div",
        // array('class_1', 'class_2');
        private array $classes = array(),
        // "default", "none", "large", "medium", "small", number
        private $padding_top = "default",
        private $padding_bottom = "default",
        // "default", "none", "large", "medium", "small", number
        private $margin_top = "default",
        private $margin_bottom = "default",
        // array("color:red", "display:block");
        private $inline_css = array(),
        // id
        private string $id = "",
        // the params array that will be passed to the module function
        private array $params = array(),
        private $remove_top_wave = false,
        private $remove_bottom_wave = false
    ) 
    {
        // add these classes to the beginning of the class list
        array_unshift($this->classes, "module", "fm_{$this->name}");
        
        $this->process_module_output();
        $this->process_fm_overrides();
        
        $this->process_background_color();
        $this->process_padding();
        $this->process_margin();
        $this->process_class_string();
        $this->process_inline_css_string();
    }
    public function process_module_output()
    {
        ob_start();
        $this->fm_overrides = ("fm_" . $this->name)(...$this->params);
        $this->module_output = ob_get_contents();
        ob_end_clean();
    }
    public function process_fm_overrides()
    {
        // if the fm_overrides is a good array
        if ( ga($this->fm_overrides) )
        {
            foreach ( $this->fm_overrides as $key => $value )
            {
                // if the original value for this key is an array we want to merge the two so that we dont lose the original values set by the user in the page builder (for example, css classes and inline css). theres nothing special about them being arrays - per se - but looking at the parameter list for this class, the ones that make the most sense to not override happened to be arrays
                if ( ga($this->$key) )
                {
                    // if the new value for this key is an array
                    if ( ga($value) )
                    {
                        // merge the two arrays
                        $this->$key = array_merge($this->$key, $value);
                    }
                }
                // if it's not an array, just overwrite it.
                else
                {
                    $this->$key = $value;
                }
            }
        }
    }
    
    public function wrap()
    {
        
        echo "<{$this->element} ";
            echo $this->id ? "id='{$this->id}' " : null;
            echo $this->class_string ? "class='{$this->class_string}' " : null;
            echo $this->inline_css_string ? "style='{$this->inline_css_string}' " : null;
        echo ">";
            echo $this->module_output;
        echo "</{$this->element}>";
    }
    private function process_background_color() {
        
        if ( $this->background_color ) {
            $bg_classes = explode(' ', $this->background_color);
            if ( is_array($bg_classes) ) {
                foreach ( $bg_classes as $class ) {
                    $this->classes[] = $class;
                }
            }
        }
    }
    private function process_class_string()
    {
        		

	if ( $this->remove_bottom_wave )
	{

		if (($key = array_search("wave_bottom", $this->classes)) !== false) {
		    unset($this->classes[$key]);
		}
	}
	            	
        
        $this->class_string = implode(" ", array_filter($this->classes));
    }private function process_inline_css_string()
    {
        $this->inline_css_string = implode(";", $this->inline_css);
    }
    private function process_padding()
    {
        
        if ( is_numeric($this->padding_top) )
        {
            $this->inline_css[] = "padding-top:{$this->padding_top}px";
            $this->classes[] = "padding_top_custom";

        } else
        {
            if ( $this->padding_top )
            {
                $this->classes[] = "padding_top_{$this->padding_top}";
            }
        }
        if ( is_numeric($this->padding_bottom) )
        {
            $this->inline_css[] = "padding-bottom:{$this->padding_bottom}px";
            $this->classes[] = "padding_bottom_custom";

        } else
        {
            if ( $this->padding_bottom )
            {
                $this->classes[] = "padding_bottom_{$this->padding_bottom}";
            }
        }
    }
    private function process_margin()
    {
        if ( is_numeric($this->margin_top) )
        {
            $this->inline_css[] = "margin-top:{$this->margin_top}px";
            $this->classes[] = "margin_top_custom";

        } else
        {
            if ( $this->margin_top )
            {   
                $this->classes[] = "margin_top_{$this->margin_top}";
            }
        }
        if ( is_numeric($this->margin_bottom) )
        {
            $this->inline_css[] = "margin-bottom:{$this->margin_bottom}px";
            $this->classes[] = "margin_bottom_custom";

        } else
        {
            if ( $this->margin_bottom )
            {
                $this->classes[] = "margin_bottom_{$this->margin_bottom}";
            }
        }
    }

    
}