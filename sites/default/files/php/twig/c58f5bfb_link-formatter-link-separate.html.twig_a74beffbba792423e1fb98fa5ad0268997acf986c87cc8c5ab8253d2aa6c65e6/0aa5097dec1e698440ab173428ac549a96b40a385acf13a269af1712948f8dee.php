<?php

/* core/themes/classy/templates/field/link-formatter-link-separate.html.twig */
class __TwigTemplate_eeab1e864c8ee770d633f230388f499569daf7a5a2c1dea0ed86b976113a47b2 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $tags = array("spaceless" => 15, "if" => 17);
        $filters = array();
        $functions = array();

        try {
            $this->env->getExtension('sandbox')->checkSecurity(
                array('spaceless', 'if'),
                array(),
                array()
            );
        } catch (Twig_Sandbox_SecurityError $e) {
            $e->setTemplateFile($this->getTemplateName());

            if ($e instanceof Twig_Sandbox_SecurityNotAllowedTagError && isset($tags[$e->getTagName()])) {
                $e->setTemplateLine($tags[$e->getTagName()]);
            } elseif ($e instanceof Twig_Sandbox_SecurityNotAllowedFilterError && isset($filters[$e->getFilterName()])) {
                $e->setTemplateLine($filters[$e->getFilterName()]);
            } elseif ($e instanceof Twig_Sandbox_SecurityNotAllowedFunctionError && isset($functions[$e->getFunctionName()])) {
                $e->setTemplateLine($functions[$e->getFunctionName()]);
            }

            throw $e;
        }

        // line 15
        ob_start();
        // line 16
        echo "  <div class=\"link-item\">
    ";
        // line 17
        if ((isset($context["title"]) ? $context["title"] : null)) {
            // line 18
            echo "      <div class=\"link-title\">";
            echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, (isset($context["title"]) ? $context["title"] : null), "html", null, true));
            echo "</div>
    ";
        }
        // line 20
        echo "    <div class=\"link-url\">";
        echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, (isset($context["link"]) ? $context["link"] : null), "html", null, true));
        echo "</div>
  </div>
";
        echo trim(preg_replace('/>\s+</', '><', ob_get_clean()));
    }

    public function getTemplateName()
    {
        return "core/themes/classy/templates/field/link-formatter-link-separate.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  56 => 20,  50 => 18,  48 => 17,  45 => 16,  43 => 15,);
    }
}
/* {#*/
/* /***/
/*  * @file*/
/*  * Theme override of a link with separate title and URL elements.*/
/*  **/
/*  * Available variables:*/
/*  * - link: The link that has already been formatted by l().*/
/*  * - title: (optional) A descriptive or alternate title for the link, which may*/
/*  *   be different than the actual link text.*/
/*  **/
/*  * @see template_preprocess()*/
/*  * @see template_preprocess_link_formatter_link_separate()*/
/*  *//* */
/* #}*/
/* {% spaceless %}*/
/*   <div class="link-item">*/
/*     {% if title %}*/
/*       <div class="link-title">{{ title }}</div>*/
/*     {% endif %}*/
/*     <div class="link-url">{{ link }}</div>*/
/*   </div>*/
/* {% endspaceless %}*/
/* */
