<?php

/*
=====================================================
 This ExpressionEngine plugin was created by iDev27
  - http://twitter.com/iDev247
=====================================================
 File: pi.eeffing_var.php
-----------------------------------------------------
 Purpose: Stores and retrieves custom eeffing_vars.
=====================================================
*/

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$plugin_info = array(
		     'pi_name' => 'EEfing Var',
		     'pi_version' =>'1.0',
		     'pi_author' =>'iDev247',
		     'pi_author_url' => 'http://twitter.com/iDev247',
		     'pi_description' => 'Stores and retrieves sitewide variables',
		     'pi_usage' => Eeffing_var::usage()
		     );

class Eeffing_var {

  function Eeffing_var() {

    $this->EE =& get_instance();
  }
  
  function set() {
  
    // Fetch params
    $name    = $this->EE->TMPL->fetch_param('name');
    $value   = $this->EE->TMPL->fetch_param('value');

    $this->EE->config->config['eeffing_var'][$name] = $value;
  }
  // End of store function

  
  function get() {
    
     // Fetch the tagdata
     $tagdata = $this->EE->TMPL->tagdata;

     // Fetch param
     $name = $this->EE->TMPL->fetch_param('name');

     // Retrieve eeffing_var value
     if(!empty($this->EE->config->config['website_lang'])) {
         $value = $this->EE->config->config['website_lang'];
     } else {
         $value = 'en';
     }
    
     // Put eeffing_var value into conditionals array
     $conds['eeffing_var'] = $value;     
    
     // Check if there is {eeffing_var} variable or a conditional placed between {exp:eeffing_var} and {/exp:eeffing_var} tag pair 
     if (strpos($tagdata, 'eeffing_var') > 0 OR strpos($tagdata, 'eeffing_var') === 0) {
     
       // Evaluate if-conditional
       $tagdata = $this->EE->functions->prep_conditionals($tagdata, $conds);
       // Return eeffing_var value as {eeffing_var} variable's output
       $tagdata = str_replace('{eeffing_var}', $value, $tagdata);
       return $tagdata;
     }
     else {
     
     // If there is no {eeffing_var} variable, then return eeffing_var value as output of single {exp:eeffing_var} tag
     return $value; 
     }

  }
  // End of retrieve function

  
  
function usage()
  {
  ob_start(); 
  ?>

Usage:

To set an eeffing var:

{exp:eeffing_var:set name="language" value="en"}

To retrieve an eeffing var:

{exp:eeffing_var:get name="language"}

OR

{exp:eeffing_var:get name="language" parse="inward"}
{exp:weblog:entries weblog="pages-{eeffing_var}"}
Some code
{/exp:weblog:entries}
{/exp:eeffing_var:get}

OR

{exp:eeffing_var:get name="language"}
{if eeffing_var == "fr"}
Some code
{/if}
{/exp:eeffing_var:get}

  <?php
  $buffer = ob_get_contents();
  
  ob_end_clean(); 

  return $buffer;
  }
  // END USAGE
  
  
}//End

?>