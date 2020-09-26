{% extends "layouts/main.twig" %}

{% block content %}
    <div class="jumbotron">
        <div class="container text-center">
            <h1>Error 404</h1>
            <img src="{{ resource('img/404.png') }}" alt="">
            <p>Ruta no encontrado en el dominio {{ route }}</p>
        </div>
    </div>
{% endblock %}