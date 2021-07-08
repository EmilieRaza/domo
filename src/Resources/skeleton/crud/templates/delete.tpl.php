{% extends "back/layout.html.twig" %}

{% block content %}
    <section>
        <div class="container">
            <h2>Suppression - <?= $entity_class_name ?> ({{ <?= $entity_twig_var_singular ?> }})</h2>
            <hr>
            <div class="col-sm-8 col-sm-offset-2">
                <div class="alert alert-warning">Êtes-vous sûr de ce que vous faites ?</div>
                {{ form_start(form) }}        
                    <button class="btn btn-primary btn-sm">Supprimer</button>
                    <a href="{{ path('<?= $route_name ?>_search') }}" class="btn btn-primary" role="button"><i class="fa fa-reply"></i> Retour</a>
                {{ form_end(form) }}
            </div>
        </div>
    </section>
{% endblock %}