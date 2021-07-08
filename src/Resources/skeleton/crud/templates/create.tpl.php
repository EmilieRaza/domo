{% extends 'back/layout.html.twig' %}

{% block title %} Ajouter {{'<?= $entity_class_name ?>'|transchoice(1)}} {% endblock %}

{% block content %}

<section class="section-padding">
    <div class="container">
        <h1>Ajouter {{'<?= $entity_class_name ?>'|transchoice(1)}}</h1>
        <div class="shape"></div>
        <div class="text-right mt-4">
            <a href="{{ path('<?= $route_name ?>_search') }}" class="btn btn-primary" role="button">
                <i class="fa fa-reply"></i> Retour
            </a>
        </div>
        <div class="card mt-4 mb-4">
            <div class="card-header text-center">
                <h4>Formulaire {{'<?= $entity_class_name ?>'|transchoice(1)}}</h4>
            </div>
            <div class="card-content">
                {{ form_start(form) }}
                    <?php foreach ($entity_fields as $field): ?>
                    <?php if ($field['fieldName'] != $entity_identifier): ?>
                        {{ form_row(form.<?= $field['fieldName'] ?>) }}
                    <?php endif; ?>
                    <?php endforeach; ?>
                    <br>
                    <button class="btn btn-primary">Ajouter</button>
                {{ form_end(form) }}
            </div>
        </div>
    </div>
</section>
{% endblock %}