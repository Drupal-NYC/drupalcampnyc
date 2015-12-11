<?php

/* core/themes/classy/templates/field/field--comment.html.twig */
class __TwigTemplate_530976b6eb158c012f1ae19cfff63f1d74488cc082842c8abda993b4ff6b0964 extends Twig_Template
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
        $tags = array("set" => 29, "if" => 44);
        $filters = array("clean_class" => 31, "t" => 53);
        $functions = array();

        try {
            $this->env->getExtension('sandbox')->checkSecurity(
                array('set', 'if'),
                array('clean_class', 't'),
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

        // line 29
        $context["classes"] = array(0 => "field", 1 => ("field--name-" . \Drupal\Component\Utility\Html::getClass(        // line 31
(isset($context["field_name"]) ? $context["field_name"] : null))), 2 => ("field--type-" . \Drupal\Component\Utility\Html::getClass(        // line 32
(isset($context["field_type"]) ? $context["field_type"] : null))), 3 => ("field--label-" .         // line 33
(isset($context["label_display"]) ? $context["label_display"] : null)), 4 => "comment-wrapper");
        // line 38
        $context["title_classes"] = array(0 => "title", 1 => (((        // line 40
(isset($context["label_display"]) ? $context["label_display"] : null) == "visually_hidden")) ? ("visually-hidden") : ("")));
        // line 43
        echo "<section";
        echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, $this->getAttribute((isset($context["attributes"]) ? $context["attributes"] : null), "addClass", array(0 => (isset($context["classes"]) ? $context["classes"] : null)), "method"), "html", null, true));
        echo ">
  ";
        // line 44
        if (((isset($context["comments"]) ? $context["comments"] : null) &&  !(isset($context["label_hidden"]) ? $context["label_hidden"] : null))) {
            // line 45
            echo "    ";
            echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, (isset($context["title_prefix"]) ? $context["title_prefix"] : null), "html", null, true));
            echo "
    <h2";
            // line 46
            echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, $this->getAttribute((isset($context["title_attributes"]) ? $context["title_attributes"] : null), "addClass", array(0 => (isset($context["title_classes"]) ? $context["title_classes"] : null)), "method"), "html", null, true));
            echo ">";
            echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, (isset($context["label"]) ? $context["label"] : null), "html", null, true));
            echo "</h2>
    ";
            // line 47
            echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, (isset($context["title_suffix"]) ? $context["title_suffix"] : null), "html", null, true));
            echo "
  ";
        }
        // line 49
        echo "
  ";
        // line 50
        echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, (isset($context["comments"]) ? $context["comments"] : null), "html", null, true));
        echo "

  ";
        // line 52
        if ((isset($context["comment_form"]) ? $context["comment_form"] : null)) {
            // line 53
            echo "    <h2 class=\"title comment-form__title\">";
            echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->renderVar(t("Add new comment")));
            echo "</h2>
    ";
            // line 54
            echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, (isset($context["comment_form"]) ? $context["comment_form"] : null), "html", null, true));
            echo "
  ";
        }
        // line 56
        echo "
</section>
";
    }

    public function getTemplateName()
    {
        return "core/themes/classy/templates/field/field--comment.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  94 => 56,  89 => 54,  84 => 53,  82 => 52,  77 => 50,  74 => 49,  69 => 47,  63 => 46,  58 => 45,  56 => 44,  51 => 43,  49 => 40,  48 => 38,  46 => 33,  45 => 32,  44 => 31,  43 => 29,);
    }
}
/* {#*/
/* /***/
/*  * @file*/
/*  * Theme override for comment fields.*/
/*  **/
/*  * Available variables:*/
/*  * - attributes: HTML attributes for the containing element.*/
/*  * - label_hidden: Whether to show the field label or not.*/
/*  * - title_attributes: HTML attributes for the title.*/
/*  * - label: The label for the field.*/
/*  * - title_prefix: Additional output populated by modules, intended to be*/
/*  *   displayed in front of the main title tag that appears in the template.*/
/*  * - title_suffix: Additional title output populated by modules, intended to*/
/*  *   be displayed after the main title tag that appears in the template.*/
/*  * - comments: List of comments rendered through comment.html.twig.*/
/*  * - comment_form: The 'Add new comment' form.*/
/*  * - comment_display_mode: Is the comments are threaded.*/
/*  * - comment_type: The comment type bundle ID for the comment field.*/
/*  * - entity_type: The entity type to which the field belongs.*/
/*  * - field_name: The name of the field.*/
/*  * - field_type: The type of the field.*/
/*  * - label_display: The display settings for the label.*/
/*  **/
/*  * @see template_preprocess_field()*/
/*  * @see comment_preprocess_field()*/
/*  *//* */
/* #}*/
/* {%*/
/*   set classes = [*/
/*     'field',*/
/*     'field--name-' ~ field_name|clean_class,*/
/*     'field--type-' ~ field_type|clean_class,*/
/*     'field--label-' ~ label_display,*/
/*     'comment-wrapper',*/
/*   ]*/
/* %}*/
/* {%*/
/*   set title_classes = [*/
/*     'title',*/
/*     label_display == 'visually_hidden' ? 'visually-hidden',*/
/*   ]*/
/* %}*/
/* <section{{ attributes.addClass(classes) }}>*/
/*   {% if comments and not label_hidden %}*/
/*     {{ title_prefix }}*/
/*     <h2{{ title_attributes.addClass(title_classes) }}>{{ label }}</h2>*/
/*     {{ title_suffix }}*/
/*   {% endif %}*/
/* */
/*   {{ comments }}*/
/* */
/*   {% if comment_form %}*/
/*     <h2 class="title comment-form__title">{{ 'Add new comment'|t }}</h2>*/
/*     {{ comment_form }}*/
/*   {% endif %}*/
/* */
/* </section>*/
/* */
