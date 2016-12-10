{% extends "layout.tpl.php" %}
{% block content %}
<h1>{{title}}</h1>
{{ parent() }}

<div>
    <a href ='{{baseUrl}}index.php?q=news/add'>Добавить новость</a>
</div>

{% endblock %}

