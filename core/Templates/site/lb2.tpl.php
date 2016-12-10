{% extends "layout.tpl.php" %}
{% block content %}
<h3>Table Of Contents</h3>
{{ parent() }}
<div>
    <a href ='{{content}}'>{{content}}</a>
</div>
<div>
    <a href ='{{baseUrl}}index.php?q=news/add'>Добавить новость</a>
</div>


{% endblock %}
