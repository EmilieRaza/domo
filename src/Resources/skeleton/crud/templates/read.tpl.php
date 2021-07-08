{% extends 'back/layout.html.twig' %}

{% block title %} Voir {{'<?= $entity_class_name ?>'|transchoice(1)}} {% endblock %}

{% block content %}

<section class="section-padding">
    <div class="container">
        <h1>Voir {{'<?= $entity_class_name ?>'|transchoice(1)}}</h1>
        <div class="shape"></div>

        <div class="text-right mt-4">
            <a href="{{ path('<?= $route_name ?>_search') }}" class="btn btn-primary" role="button">
                <i class="fa fa-reply"></i> Retour
            </a>
        </div>
        <div class="card mt-4 mb-4">
            <div class="card-header text-center">
                <h4>Détail {{'<?= $entity_class_name ?>'|transchoice(1)}}</h4>
            </div>
            <div class="card-content">
                <?php foreach ($entity_fields as $field): ?>
                    <div class="read-content">
                        <p>
                            <strong>{% trans %}<?= str_replace('_', ' ', ucfirst($field['fieldName'])) ?>{% endtrans %}</strong> : 
                            {{ <?= $helper->getEntityFieldPrintCode($entity_twig_var_singular, $field) ?> }}
                        </p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>
{% endblock %}