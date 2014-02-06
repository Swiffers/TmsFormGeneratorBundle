
// FormField

function FormFieldConstraint($field, ajaxUrl, ajaxLoaderPath) {
    this.$field = $field;
    this.ajaxUrl = ajaxUrl;
    this.ajaxLoaderPath = ajaxLoaderPath;
    this.$constraint = this.$field.find('.form_field_constraint_choice');
    this.$options = this.$field.find('.tms_form_generator_form_field_constraint_options');
    this.id = this.$options.attr('id');
    this.init();
}

FormFieldConstraint.prototype.init = function() {

    if (this.$constraint.length  == 0) {
        return false;
    }

    this.loadData(this.$constraint.val());

    var that = this;
    this.$constraint.on('change', function(event) {
        event.preventDefault();
        that.loadData($(this).val());
    });
}

FormFieldConstraint.prototype.loadData = function(constraint) {
    var $container = this.$options.siblings('.tms_form_generator_form_field_constraint_container');
    if ($container.length) {
        $container.empty();
    } else {
        $container = $('<div class="tms_form_generator_form_field_constraint_container"></div>');
        this.$options.parent('.inputs').append($container);
    }

    var $ajaxLoader = $('<img src="'+this.ajaxLoaderPath+'" />');
    $container.append($ajaxLoader);
    this.$options.hide();
    var name = this.$options.attr('name');
    var data = this.$options.val();
    var id = this.id;

    var request = $.ajax({
        url: this.ajaxUrl,
        type: "GET",
        data: { name: this.id, constraint: constraint, data: btoa(data) },
        dataType: "html"
    });

    request.done(function(form) {
        var fields = $(form).html();
        var regExp = new RegExp('name="'+id, 'g')
        fields = fields.replace(regExp, 'name="'+name);
        $container.append(fields);
        $ajaxLoader.remove();
    });

    request.fail(function(jqXHR, textStatus) {
        alert("Request failed: " + textStatus);
    });
}


// FormFieldConstraintManager

function FormFieldConstraintManager($container) {
    this.$container = $container;

    this.$container.append(this.createAddConstraintLink());
    var that = this;
    this.$container.find('.tms_form_generator_form_field_constraint').each(function() {
        $(this).append(that.createDeleteConstraintLink());
    });
}

FormFieldConstraintManager.prototype.createAddConstraintLink = function() {
    var $addLink = $('<a href="#" class="btn btn-default add_constraint_link">Add constraint</a>');

    var that = this;
    $addLink.on('click', function(e) {
        e.preventDefault();
        that.addConstraint($(this));
    });

    return $addLink;
}

FormFieldConstraintManager.prototype.createDeleteConstraintLink = function() {
    var $deleteLink = $('<a href="#" class="btn btn-default delete_constraint_link">Delete constraint</a>');

    $deleteLink.on('click', function(e) {
        e.preventDefault();
        $(this).closest('fieldset').remove();
    });

    return $deleteLink;
}

FormFieldConstraintManager.prototype.createPrototypeForm = function() {
    var prototype = this.$container.attr('data-prototype');

    return $(prototype.replace(/__name__/g, this.$container.children().length));
}

FormFieldConstraintManager.prototype.addConstraint = function($addLink) {
    $newForm = this.createPrototypeForm();
    $newForm.append(this.createDeleteConstraintLink());
    $addLink.before($newForm);
}
