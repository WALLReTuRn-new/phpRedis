<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;

/* app/views/common/footer.twig */
class __TwigTemplate_32b0d10ffad5ddaf5802b29f7ceac460 extends \Twig\Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
        ];
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 1
        echo "
<!-- End Bottom Background Image Wrapper -->
<!-- ################################################################################################ -->
<!-- ################################################################################################ -->
<!-- ################################################################################################ -->
<a id=\"backtotop\" href=\"#top\"><i class=\"fas fa-chevron-up\"></i></a>

<script id=\"j-backtoptop\" src=\"";
        // line 8
        echo ($context["jbacktoptop"] ?? null);
        echo "\" type=\"text/javascript\"></script>
<script id=\"j-popper\" src=\"";
        // line 9
        echo ($context["jpopper"] ?? null);
        echo "\" type=\"text/javascript\"></script>
<script id=\"j-bootstrap\" src=\"";
        // line 10
        echo ($context["jbootstrap"] ?? null);
        echo "\" type=\"text/javascript\"></script>
<script id=\"j-common\" src=\"";
        // line 11
        echo ($context["jcommon"] ?? null);
        echo "\" type=\"text/javascript\"></script>

<!-- Copyright Ends -->
";
        // line 14
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["scripts"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["script"]) {
            // line 15
            echo "    <script id=\"";
            echo twig_get_attribute($this->env, $this->source, $context["script"], "name", [], "any", false, false, false, 15);
            echo "\" src=\"";
            echo twig_get_attribute($this->env, $this->source, $context["script"], "href", [], "any", false, false, false, 15);
            echo "\" type=\"text/javascript\"></script>
";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['script'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 17
        echo "</body>
</html>
";
    }

    public function getTemplateName()
    {
        return "app/views/common/footer.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  79 => 17,  68 => 15,  64 => 14,  58 => 11,  54 => 10,  50 => 9,  46 => 8,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "app/views/common/footer.twig", "C:\\xampp\\htdocs\\phpredis\\app\\views\\common\\footer.twig");
    }
}
