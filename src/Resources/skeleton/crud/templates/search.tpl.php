{% extends 'back/layout.html.twig' %}
{% block title %} Gestion {{'<?= $entity_class_name ?>'|transchoice(2)}} {% endblock %}

{% block content %}

{# ///////////////// MODAL DELETE ////////////////////#}
    <div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Suppression d'un enregistrement</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
              <form method="post" action="">
                    <input id="token" type="hidden" name="_token" value="">
                    <input type="hidden" name="_method" value="DELETE">
                    <button type="submit" class="btn btn-danger">Supprimer</button>
              </form>
            </div>
          </div>
        </div>
    </div>
{# ///////////////// END MODAL DELETE ////////////////////#}

<section class="section-padding">
    <div class="container">
        <h1>Gestion {{'<?= $entity_class_name ?>'|transchoice(2)}}</h1>
        <div class="shape"></div>

        <div class="text-right mt-4">
            <a href="{{ path('<?= $route_name ?>_create') }}" class="btn btn-success">
                <i class="fa fa-plus" aria-hidden="true"></i> Ajouter {{'<?= $entity_class_name ?>'|transchoice(1)}}
            </a>
        </div>

        <div class="card mt-4 mb-4">
            <div class="card-header text-center">
                <h4>Liste {{'<?= $entity_class_name ?>'|transchoice(2)}}</h4>
            </div>
            <div class="card-content">
                <div class="table-responsive mt-4 mb-4">
                    <table class="table table-striped table-bordered" id="dataTable" width="100%" cellspacing="0" data-page-length='50'>
                        <thead>
                            <tr>
                                <?php foreach ($entity_fields as $field): ?>
                                    <th>{% trans %}<?= str_replace('_', ' ', ucfirst($field['fieldName'])) ?>{% endtrans %}</th>
                                <?php endforeach; ?>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        {% for <?= $entity_twig_var_singular ?> in <?= $entity_twig_var_plural ?> %}
                            <tr>
                                <?php foreach ($entity_fields as $field): ?>
                                    <td>{{ <?= $helper->getEntityFieldPrintCode($entity_twig_var_singular, $field) ?> }}</td>
                                <?php endforeach; ?>
                                <td>
                                    <a href="{{ path('<?= $route_name ?>_read', {'<?= $entity_identifier ?>': <?= $entity_twig_var_singular ?>.<?= $entity_identifier ?>}) }}" title="Voir" class="btn btn-primary" aria-label="Voir">
                                        <i class="fa fa-file"></i>
                                    </a>
                                    <a href="{{ path('<?= $route_name ?>_update', {'<?= $entity_identifier ?>': <?= $entity_twig_var_singular ?>.<?= $entity_identifier ?>}) }}" title="Modifier" class="btn btn-warning" aria-label="Modifier">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="#" title="Supprimer" class="btn btn-danger btn-delete" data-toggle="modal" data-target="#delete" aria-label="Supprimer" id="{{<?= $entity_twig_var_singular ?>.<?= $entity_identifier ?>}}" data-title="" data-path="{{ path('<?= $route_name ?>_delete', {'<?= $entity_identifier ?>': <?= $entity_twig_var_singular ?>.<?= $entity_identifier ?>})}}">
                                        <i class="fa fa-times"></i>
                                    </a>
                                </td>
                            </tr>
                        {% else %}
                            <tr>
                                <td colspan="<?= (count($entity_fields) + 1) ?>">Aucun enregistrement</td>
                            </tr>
                        {% endfor %}
                        </tbody>
                    </table>
            </div>
        </div>
    </div>
</section>
{% endblock %}

{% block javascripts %}
    {{ parent() }}
    <script src="{{ asset('datatables/jquery.dataTables.js')}}"></script>
    <script src="{{ asset('datatables/dataTables.bootstrap4.js')}}"></script>
    <script>
            $(document).ready(function(){
                $(document).on ("click", ".btn-delete", function () {
                    var id = $(this).attr('id');
                    var title = $(this).attr('data-title');
                    var path = $(this).attr('data-path');
                    $('.modal-footer form').attr('action', path);
                    $('#token').val("{{ csrf_token('delete' ~"+id+") }}");
                    $('.modal-body').html("<p>Confirmez-vous la suppression de: <strong>"+title+"</strong></p>");
                });
            });
    </script>

    <script>
        $(document).ready(function(){$("#dataTable").DataTable()});
    </script>

    <script type="text/javascript">
        $('#dataTable').DataTable( {
            language: {
                processing:     "Traitement en cours...",
                search:         "Rechercher&nbsp;:",
                lengthMenu:    "Afficher _MENU_ &eacute;l&eacute;ments",
                info:           "Affichage de l'&eacute;lement _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",
                infoEmpty:      "Affichage de l'&eacute;lement 0 &agrave; 0 sur 0 &eacute;l&eacute;ments",
                infoFiltered:   "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
                infoPostFix:    "",
                loadingRecords: "Chargement en cours...",
                zeroRecords:    "Aucun &eacute;l&eacute;ment &agrave; afficher",
                emptyTable:     "Aucune donnée disponible dans le tableau",
                paginate: {
                    first:      "Premier",
                    previous:   "Pr&eacute;c&eacute;dent",
                    next:       "Suivant",
                    last:       "Dernier"
                },
                aria: {
                    sortAscending:  ": activer pour trier la colonne par ordre croissant",
                    sortDescending: ": activer pour trier la colonne par ordre décroissant"
                }
            },

            aaSorting: []
        } );
    </script>
{% endblock %}