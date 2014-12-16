/* =========================================================
 * composer-view.js v0.2.1
 * =========================================================
 * Copyright 2013 Wpbakery
 *
 * Visual composer backbone/underscore version
 * ========================================================= */
<<<<<<< HEAD

 (function ($) {
    var i18n = window.i18nLocale,
        store = vc.storage,
        Shortcodes = vc.shortcodes;
   vc.builder = {
       toString: function(model, type) {
           var params = model.get('params'),
               content = _.isString(params.content) ? params.content : '';
           return wp.shortcode.string({
               tag: model.get('shortcode'),
               attrs: _.omit(params, 'content'),
               content: content,
               type:_.isString(type) ? type : ''
           });
       }
   };
=======
(function ($) {
    var i18n = window.i18nLocale,
        store = vc.storage,
        Shortcodes = vc.shortcodes;
>>>>>>> master
    /**
     * Default view for shortcode as block inside Visual composer design mode.
     * @type {*}
     */
    vc.clone_index = 1;
<<<<<<< HEAD
    vc.saved_custom_css = false;
=======
>>>>>>> master
    var ShortcodeView = vc.shortcode_view = Backbone.View.extend({
        tagName:'div',
        $content:'',
        use_default_content:false,
        params:{},
        events:{
<<<<<<< HEAD
            'click .column_delete,.vc_control-btn-delete':'deleteShortcode',
            'click .column_add,.vc_control-btn-prepend':'addElement',
            'click .column_edit,.vc_control-btn-edit, .column_edit_trigger':'editElement',
            'click .column_clone,.vc_control-btn-clone':'clone',
            'mousemove': 'checkControlsPosition'
        },
        removeView:function () {
          vc.closeActivePanel(this.model);
            this.remove();
        },
        checkControlsPosition: function() {
            if(!this.$controls_buttons) return;
            var window_top, control_top, element_position_top, new_position,
                element_height = this.$el.height(),
                window_height = $(window).height();
            if(element_height > window_height) {
                window_top = $(window).scrollTop();
                control_top = this.$controls_buttons.offset().top;
                element_position_top = this.$el.offset().top;
                new_position =  (window_top - element_position_top) + $(window).height()/2;
                if(new_position > 40 && new_position < element_height) {
                    this.$controls_buttons.css('top',  new_position);
                } else if(new_position > element_height) {
                    this.$controls_buttons.css('top',  element_height - 40);

                } else {
                    this.$controls_buttons.css('top',  40);
                }
            }
        },
=======
            'click .column_delete':'deleteShortcode',
            'click .column_add':'addElement',
            'click .column_edit, .column_edit_trigger':'editElement',
            'click .column_clone':'clone'
        },
        removeView:function () {
            this.remove();
        },
>>>>>>> master
        initialize:function () {
            this.model.bind('destroy', this.removeView, this);
            this.model.bind('change:params', this.changeShortcodeParams, this);
            this.model.bind('change_parent_id', this.changeShortcodeParent, this);
            this.createParams();
        },
        createParams:function () {
            var tag = this.model.get('shortcode'),
                params = _.isObject(vc.map[tag]) && _.isArray(vc.map[tag].params) ? vc.map[tag].params : [];
<<<<<<< HEAD
            this.params = {};
=======
>>>>>>> master
            _.each(params, function (param) {
                this.params[param.param_name] = param;
            }, this);
        },
        setContent:function () {
            this.$content = this.$el.find('> .wpb_element_wrapper > .vc_container_for_children');
        },
        setEmpty:function () {
        },
        unsetEmpty:function () {

        },
        checkIsEmpty:function () {
            if (this.model.get('parent_id')) {
                vc.app.views[this.model.get('parent_id')].checkIsEmpty();
            }
        },

        /**
         * Convert html into correct element
         * @param html
         */
        html2element:function (html) {
            var attributes = {},
                $template;
            if (_.isString(html)) {
                this.template = _.template(html);
                $template = $(this.template(this.model.toJSON()).trim());
            } else {
                this.template = html;
                $template = html;
            }
            _.each($template.get(0).attributes, function (attr) {
                attributes[attr.name] = attr.value;
            });
            this.$el.attr(attributes).html($template.html());
            this.setContent();
            this.renderContent();
        },
        render:function () {
<<<<<<< HEAD
            if ($('#vc_shortcode-template-' + this.model.get('shortcode')).is('script')) {
                this.html2element(_.template($('#vc_shortcode-template-' + this.model.get('shortcode')).html(), this.model.toJSON()));
=======
            if ($('#vc-shortcode-template-' + this.model.get('shortcode')).is('script')) {
                this.html2element(_.template($('#vc-shortcode-template-' + this.model.get('shortcode')).html(), this.model.toJSON()));
>>>>>>> master
            } else {
                var params = this.model.get('params');
                $.ajax({
                    type:'POST',
                    url:window.ajaxurl,
                    data:{
                        action:'wpb_get_element_backend_html',
                        data_element:this.model.get('shortcode'),
                        data_width:_.isUndefined(params.width) ? '1/1' : params.width
                    },
                    dataType:'html',
                    context:this
                }).done(function (html) {
                        this.html2element(html);
                    });
            }
<<<<<<< HEAD
            this.model.view = this;
            this.$controls_buttons = this.$el.find('.vc_controls > :first');
=======
>>>>>>> master
            return this;
        },
        renderContent:function () {
            this.$el.attr('data-model-id', this.model.get('id'));
            this.$el.data('model', this.model);
            return this;
        },
        changedContent:function (view) {
        },
        _loadDefaults:function () {
            var tag = this.model.get('shortcode');
            if (this.use_default_content === true && _.isObject(vc.map[tag]) && _.isString(vc.map[tag].default_content) && vc.map[tag].default_content.length) {
                this.use_default_content = false;
                Shortcodes.createFromString(vc.map[tag].default_content, this.model);
            }
        },
        _callJsCallback:function () {
            //Fire INIT callback if it is defined
            var tag = this.model.get('shortcode');
            if (_.isObject(vc.map[tag]) && _.isObject(vc.map[tag].js_callback) && !_.isUndefined(vc.map[tag].js_callback.init)) {
                var fn = vc.map[tag].js_callback.init;
                window[fn](this.$el);
            }
        },
        ready:function (e) {
            this._loadDefaults();
            this._callJsCallback();
            if (this.model.get('parent_id') && _.isObject(vc.app.views[this.model.get('parent_id')])) {
                vc.app.views[this.model.get('parent_id')].changedContent(this);
            }
            return this;
        },
        // View utils {{
        addShorcode:function (model) {
            var view = new ShortcodeView({model:model});
            this.$content.append(view.render().el);
            app.setSortable();
        },
        changeShortcodeParams:function (model) {
            var params = model.get('params'),
                settings = vc.map[model.get('shortcode')],
                inverted_value;
            if (_.isArray(settings.params)) {
                _.each(settings.params, function (p) {
                    var name = p.param_name,
                        value = params[name],
                        $wrapper = this.$el.find('> .wpb_element_wrapper'),
                        label_value = value,
                        $admin_label = $wrapper.children('.admin_label_' + name);
                    if (_.isObject(vc.atts[p.type]) && _.isFunction(vc.atts[p.type].render)) {
                        value = vc.atts[p.type].render.call(this, p, value);
                    }
<<<<<<< HEAD
                    if ($wrapper.children('.' + p.param_name).is('input,textarea,select')) {
                      $wrapper.children('[name=' + p.param_name + ']').val(value);
=======
                    if ($wrapper.children('.' + p.param_name).is('div, h1,h2,h3,h4,h5,h6, span, i, b, strong, button')) {
                        $wrapper.children('[name=' + p.param_name + ']').html(value);
>>>>>>> master
                    } else if ($wrapper.children('.' + p.param_name).is('iframe')) {
                        $wrapper.children('[name=' + p.param_name + ']').attr('src', value);
                    } else if ($wrapper.children('.' + p.param_name).is('img')) {
                      var $img = $wrapper.children('[name=' + p.param_name + ']');
                      if(value && value.match(/^\d+$/)) {
                        $.ajax({
                          type:'POST',
                          url:window.ajaxurl,
                          data:{
                            action:'wpb_single_image_src',
                            content: value,
                            size: 'thumbnail'
                          },
                          dataType:'html',
                          context:this
                        }).done(function (url) {
                            $img.attr('src', url);
                          });
                      } else if(value) {
                        $img.attr('src', value);
                      }
                    } else {
<<<<<<< HEAD
                      $wrapper.children('[name=' + p.param_name + ']').html(value ? value : '');
                    }
                    if ($admin_label.length) {
                        if(value === '' || _.isUndefined(value)) {
                          $admin_label.hide().addClass('hidden-label');
                        } else {
                          if (_.isObject(p.value) && !_.isArray(p.value) && p.type == 'checkbox') {
                            inverted_value = _.invert(p.value);
                            label_value = _.map(value.split(/[\s]*\,[\s]*/),function (val) {
                              return _.isString(inverted_value[val]) ? inverted_value[val] : val;
                            }).join(', ');
                          } else if (_.isObject(p.value) && !_.isArray(p.value)) {
                            inverted_value = _.invert(p.value);
                            label_value = _.isString(inverted_value[value]) ? inverted_value[value] : value;
                          }
                          $admin_label.html('<label>' + $admin_label.find('label').text() + '</label>: ' + label_value);
                          $admin_label.show().removeClass('hidden-label');
                        }
=======
                        $wrapper.children('[name=' + p.param_name + ']').val(value);
                    }
                    if ($admin_label.length) {
                        if (_.isObject(p.value) && !_.isArray(p.value) && p.type == 'checkbox') {
                            inverted_value = _.invert(p.value);
                            label_value = _.map(value.split(/[\s]*\,[\s]*/),function (val) {
                                return _.isString(inverted_value[val]) ? inverted_value[val] : val;
                            }).join(', ');
                        } else if (_.isObject(p.value) && !_.isArray(p.value)) {
                            inverted_value = _.invert(p.value);
                            label_value = _.isString(inverted_value[value]) ? inverted_value[value] : value;
                        }
                        $admin_label.html('<label>' + $admin_label.find('label').text() + '</label>: ' + label_value);
                        if (value !== '' && !_.isUndefined(value))
                            $admin_label.show().removeClass('hidden-label');
                        else
                            $admin_label.hide().addClass('hidden-label');
>>>>>>> master
                    }
                }, this);
            }
            if (this.model.get('parent_id') !== false && _.isObject(view = vc.app.views[this.model.get('parent_id')])) {
                view.checkIsEmpty();
            }
        },
        changeShortcodeParent:function (model) {
            if (this.model.get('parent_id') === false) return model;
            var $parent_view = $('[data-model-id=' + this.model.get('parent_id') + ']'),
                view = vc.app.views[this.model.get('parent_id')];
            this.$el.appendTo($parent_view.find('> .wpb_element_wrapper > .wpb_column_container'));
            view.checkIsEmpty();
        },
        // }}
        // Event Actions {{
        deleteShortcode:function (e) {
            if (_.isObject(e)) e.preventDefault();
            var answer = confirm(i18n.press_ok_to_delete_section);
            if (answer === true) this.model.destroy();
        },

        addElement:function (e) {
<<<<<<< HEAD
            _.isObject(e) && e.preventDefault();
            // new ElementBlockView({model:{position_to_add:!_.isObject(e) || !$(e.currentTarget).closest('.bottom-controls').hasClass('bottom-controls') ? 'start' : 'end'}}).show(this);
          vc.add_element_block_view.render(this.model, !_.isObject(e) || !$(e.currentTarget).closest('.bottom-controls').hasClass('bottom-controls'));
        },
        editElement:function (e) {
            if (_.isObject(e)) e.preventDefault();
          vc.edit_element_block_view.render(this.model);
=======
            if (_.isObject(e)) e.preventDefault();
            new ElementBlockView({model:{position_to_add:!_.isObject(e) || !$(e.currentTarget).closest('.bottom-controls').hasClass('bottom-controls') ? 'start' : 'end'}}).show(this);
        },
        editElement:function (e) {
            if (_.isObject(e)) e.preventDefault();
            var settings_view = new SettingsView({model:this.model});
            settings_view.show();
>>>>>>> master
        },
        clone:function (e) {
            if (_.isObject(e)) e.preventDefault();
            vc.clone_index = vc.clone_index / 10;
            return this.cloneModel(this.model, this.model.get('parent_id'));
        },
        cloneModel:function (model, parent_id, save_order) {
            var shortcodes_to_resort = [],
                new_order = _.isBoolean(save_order) && save_order === true ? model.get('order') : parseFloat(model.get('order')) + vc.clone_index,
<<<<<<< HEAD
                model_clone = Shortcodes.create({shortcode:model.get('shortcode'), id: window.vc_guid(), parent_id:parent_id, order:new_order, cloned:true, cloned_from:model.toJSON(), params:_.extend({}, model.get('params'))});
=======
                model_clone = Shortcodes.create({shortcode:model.get('shortcode'), id:vc_guid(), parent_id:parent_id, order:new_order, cloned:true, cloned_from:model.toJSON(), params:_.extend({}, model.get('params'))});
>>>>>>> master
            _.each(Shortcodes.where({parent_id:model.id}), function (shortcode) {
                this.cloneModel(shortcode, model_clone.get('id'), true);
            }, this);
            return model_clone;
        }
        // }}
    });
<<<<<<< HEAD
=======
    /**
     * Post custom css
     * @type {Number}
     */
    var PostCustomCssBlockView = vc.post_custom_css_block_view = Backbone.View.extend({
      tagName:'div',
      className:'wpb_bootstrap_modals',
      template:_.template($('#wpb-post-custom-css-modal-template').html() || '<div></div>'),
      events: {
        'click .wpb_save_edit_form': 'save',
        'keydown .wpb_custom_post_css_editor': 'addTab'
      },
      initialize: function() {

      },
      render: function() {
        this.$field = $('#wpb_custom_post_css_field');
        $('body').append(this.$el.html(this.template()));
        this.$editor = this.$el.find('.wpb_custom_post_css_editor');
        this.$editor.val(this.$field.val());
      },
      addTab: function(e) {
        if(e.keyCode === 9) {
          // get caret position/selection
          var el = this.$editor.get(0),
              start = el.selectionStart,
              end = el.selectionEnd;
            this.$editor.val(this.$editor.val().substring(0, start)
            + "\t"
            + this.$editor.val().substring(end));
          el.selectionStart = el.selectionEnd = start + 1;
          // prevent the focus lose
          e.preventDefault();
        }
      },
      save: function() {
        this.$field.val(this.$editor.val());
        this.close();
      },
      show:function () {
        this.render();
        this.$el.modal('show');
      },
      close:function () {
        this.$el.modal('hide');
      }
    });
    /**
     * Elements list
     * @type {*}
     */
    vc.element_start_index = 0;
    var ElementBlockView = vc.element_block_view = Backbone.View.extend({
        tagName:'div',
        className:'wpb_bootstrap_modals',
        template:_.template($('#wpb-elements-list-modal-template').html() || '<div></div>'),
        data_saved:false,
        events:{
            'click [data-element]':'createElement',
            'click .close':'close',
            'hidden':'removeView',
            'shown':'setupShown',
            'click .wpb-content-layouts-container .isotope-filter a':'filterElements',
            'keyup #vc_elements_name_filter':'filterElements'
        },
        initialize:function () {
            if (_.isUndefined(this.model)) this.model = {position_to_add:'end'};
        },
        render:function () {
            var that = this,
                $container = this.container.$content,
                item_selector,
                $list,
                tag,
                not_in;
            $('body').append(this.$el.html(this.template()));
            $list = this.$el.find('.wpb-elements-list'),
            item_selector = '.wpb-layout-element-button',
            tag = this.container.model ? this.container.model.get('shortcode') : 'vc_column',
            not_in = this._getNotIn(tag);
            // New vision
            var as_parent = tag && !_.isUndefined(vc.map[tag].as_parent) ? vc.map[tag].as_parent : false;
            if (_.isObject(as_parent)) {
                var parent_selector = [];
                if (_.isString(as_parent.only)) {
                    parent_selector.push(_.reduce(as_parent.only.replace(/\s/, '').split(','), function (memo, val) {
                        return memo + ( _.isEmpty(memo) ? '' : ',') + '[data-element="' + val.trim() + '"]';
                    }, ''));
                }
                if (_.isString(as_parent.except)) {
                    parent_selector.push(_.reduce(as_parent.except.replace(/\s/, '').split(','), function (memo, val) {
                        return memo  + ':not([data-element="' + val.trim() + '"])';
                    }, ''));
                }
                item_selector += parent_selector.join(',');
            } else {
                item_selector += not_in;
            }
            // OLD fashion
            if (tag !== false && tag !== false && !_.isUndefined(vc.map[tag].allowed_container_element)) {
                if (vc.map[tag].allowed_container_element === false) {
                    item_selector += ':not([data-is-container=true])';
                } else if (_.isString(vc.map[tag].allowed_container_element)) {
                    item_selector += ':not([data-is-container=true][data-element!=' + vc.map[tag].allowed_container_element + '])';
                }
            }
            $('.wpb-content-layouts', $list).isotope({
                itemSelector:item_selector,
                layoutMode:'fitRows',
                filter:null
            });

            $('.wpb-content-layouts', $list).isotope('reloadItems');
            $('.wpb-content-layouts-container .isotope-filter a:first', $list).trigger('click');
            $('[data-filter]', this.$el).each(function () {
                if (!$($(this).data('filter') + ':visible', $list).length) $(this).hide();
            });
            return this;
        },
        _getNotIn:_.memoize(function (tag) {
            var selector = _.reduce(vc.map, function (memo, shortcode) {
                var separator = _.isEmpty(memo) ? '' : ',';
                if (_.isObject(shortcode.as_child)) {
                    if (_.isString(shortcode.as_child.only)) {
                        if (!_.contains(shortcode.as_child.only.replace(/\s/, '').split(','), tag)) {
                            memo += separator + '[data-element=' + shortcode.base + ']';
                        }
                    }
                    if (_.isString(shortcode.as_child.except)) {
                        if (_.contains(shortcode.as_child.except.replace(/\s/, '').split(','), tag)) {
                            memo += separator + '[data-element=' + shortcode.base + ']';
                        }
                    }
                } else if (shortcode.as_child === false) {
                    memo += separator + '[data-element=' + shortcode.base + ']';
                }
                return memo;
            }, '');
            return _.isEmpty(selector) ? '' : ':not(' + selector + ')';
        }),
        filterElements:function (e) {
            e.stopPropagation();
            var $list = this.$el.find('.wpb-elements-list'),
                $control = $(e.currentTarget),
                filter = '',
                name_filter = $('#vc_elements_name_filter').val();
            if ($control.is('[data-filter]')) {
                $('.wpb-content-layouts-container .isotope-filter .active', $list).removeClass('active');
                $control.parent().addClass('active');
                filter = $control.data('filter');
                $('#vc_elements_name_filter').val('');
            } else if (name_filter.length > 0) {
                filter = ":containsi('" + name_filter + "')";
                $('.wpb-content-layouts-container .isotope-filter .active', $list).removeClass('active');
            } else if(name_filter.length == 0) {
                $('.wpb-content-layouts-container .isotope-filter [data-filter="*"]').parent().addClass('active');
            }
            $('.wpb-content-layouts', $list).isotope({ filter:filter });
        },
        createElement:function (e) {
            var model, column, row;
            if (_.isObject(e)) e.preventDefault();
            var $button = $(e.currentTarget);
            if (this.container.$content.is('#visual_composer_content')) {
                row = Shortcodes.create({shortcode:'vc_row'});
                column = Shortcodes.create({shortcode:'vc_column', params:{width:'1/1'}, parent_id:row.id, root_id:row.id });
                if ($button.data('element') != 'vc_row') {
                    model = Shortcodes.create({
                        shortcode:$button.data('element'),
                        parent_id:column.id,
                        params:vc.getDefaults($button.data('element')),
                        root_id:row.id
                    });
                } else {
                    model = row;
                }
            } else {
                if ($button.data('element') == 'vc_row') {
                    row = model = Shortcodes.create({
                        shortcode:'vc_row_inner',
                        parent_id:this.container.model.id,
                        order:(this.model.position_to_add == 'start' ? this.getFirstPositionIndex() : Shortcodes.getNextOrder())
                    });
                    Shortcodes.create({shortcode:'vc_column_inner', params:{width:'1/1'}, parent_id:row.id, root_id:row.id });
                } else {
                    model = Shortcodes.create({
                        shortcode:$button.data('element'),
                        parent_id:this.container.model.id,
                        order:(this.model.position_to_add == 'start' ? this.getFirstPositionIndex() : Shortcodes.getNextOrder()),
                        params:vc.getDefaults($button.data('element')),
                        root_id:this.container.model.get('root_id')
                    });
                }
            }
            this.selected_model = _.isBoolean(vc.map[$button.data('element')].show_settings_on_create) && vc.map[$button.data('element')].show_settings_on_create === false ? false : model;
            this.$el.modal('hide');
            this.close();

        },
        getFirstPositionIndex:function () {
            vc.element_start_index -= 1;
            return vc.element_start_index;
        },
        removeView:function () {
            if (this.selected_model && this.selected_model.get('shortcode') != 'vc_row' && this.selected_model.get('shortcode') != 'vc_row_inner') {
                var settings_view = new SettingsView({model:this.selected_model});
                settings_view.show();
            }
            this.remove();
        },
        setupShown:function () {
            if(!vc.is_mobile) $('#vc_elements_name_filter').focus();
        },
        show:function (container) {
          this.container = container;
          this.render();
          this.$el.modal('show');
        },
        close:function () {
            this.$el.modal('hide');
        }
    });

    var SettingsView = Backbone.View.extend({
        tagName:'div',
        className:'wpb_bootstrap_modals',
        template:_.template($('#wpb-element-settings-modal-template').html() || '<div></div>'),
        textarea_html_checksum:'',
        dependent_elements:{},
        mapped_params:{},
        events:{
            'click .wpb_save_edit_form':'save',
            // 'click .close':'close',
            'hidden':'remove',
            'hide':'askSaveData',
            'shown':'loadContent'
        },
        content: function() {
          return this.$content;
        },
        window: function() {
          return window;
        },
        initialize:function () {
            var tag = this.model.get('shortcode'),
                params = _.isObject(vc.map[tag]) && _.isArray(vc.map[tag].params) ? vc.map[tag].params : [];
            _.bindAll(this, 'hookDependent');
            this.mapped_params = {};
            this.dependent_elements = {};
            _.each(params, function (param) {
                this.mapped_params[param.param_name] = param;
            }, this);
        },
        render:function () {
            $('body').append(this.$el.html(this.template()));
            this.$content = this.$el.find('.modal-body > div');
            return this;
        },
        initDependency:function () {
            // setup dependencies
            _.each(this.mapped_params, function (param) {
                if (_.isObject(param) && _.isObject(param.dependency) && _.isString(param.dependency.element)) {
                    var $masters = $('[name=' + param.dependency.element + ']', this.$content),
                        $slave = $('[name= ' + param.param_name + ']', this.$content);
                    _.each($masters, function (master) {
                        var $master = $(master),
                            rules = param.dependency;
                        if (!_.isArray(this.dependent_elements[$master.attr('name')])) this.dependent_elements[$master.attr('name')] = [];
                        this.dependent_elements[$master.attr('name')].push($slave);
                        $master.bind('keyup change', this.hookDependent);
                        this.hookDependent({currentTarget:$master}, [$slave]);
                        if (_.isString(rules.callback)) {
                            window[rules.callback].call(this);
                        }
                    }, this);
                }
            }, this);
        },
        hookDependent:function (e, dependent_elements) {
            var $master = $(e.currentTarget),
            master_value,
            is_empty;
            dependent_elements = _.isArray(dependent_elements) ? dependent_elements : this.dependent_elements[$master.attr('name')],
            master_value = $master.is(':checkbox') ? _.map(this.$content.find('[name=' + $(e.currentTarget).attr('name') + ']:checked'),
                    function (element) {
                    return $(element).val();
                })
                    : $master.val();
            is_empty = $master.is(':checkbox') ? !this.$content.find('[name=' + $master.attr('name') + ']:checked').length
                    : !master_value.length;
            if($master.is(':hidden') && !$master.is('[type=hidden]')) {
                _.each(dependent_elements, function($element) {
                    $element.closest('.vc_row-fluid').hide();
                });
            } else {
                _.each(dependent_elements, function ($element) {
                    var param_name = $element.attr('name'),
                        rules = _.isObject(this.mapped_params[param_name]) && _.isObject(this.mapped_params[param_name].dependency) ? this.mapped_params[param_name].dependency : {},
                        $param_block = $element.closest('.vc_row-fluid');
                    if (_.isBoolean(rules.not_empty) && rules.not_empty === true && !is_empty) { // Check is not empty show dependent Element.
                        $param_block.show();
                    } else if (_.isBoolean(rules.is_empty) && rules.is_empty === true && is_empty) {
                        $param_block.show();
                    } else if (_.intersection((_.isArray(rules.value) ? rules.value : [rules.value]), (_.isArray(master_value) ? master_value : [master_value])).length) {
                        $param_block.show();
                    } else {
                        $param_block.hide();
                    }
                    $element.trigger('change');
                }, this);
            }
            return this;
        },
        loadContent:function () {
            $.ajax({
                type:'POST',
                url:window.ajaxurl,
                data:{
                    action:'wpb_show_edit_form',
                    element:this.model.get('shortcode'),
                    post_id: $('#post_ID').val(),
                    shortcode:store.createShortcodeString(this.model.toJSON()) // TODO: do it on server-side
                },
                context:this
            }).done(function (data) {
                    this.$content.html(data);
                    this.$el.find('h3').text(this.$content.find('> [data-title]').data('title'));
                    this.initDependency();
                });
        },
        save:function (e) {
            if (_.isObject(e)) e.preventDefault();
            var params = this.getParams();
            this.model.save({params:params});
            if(parseInt(Backbone.VERSION)=== 0) {
                this.model.trigger('change:params', this.model);
            }
            this.data_saved = true;
            this.close();
            return this;
        },
        getParams: function() {
            var attributes_settings = this.mapped_params,
                params = jQuery.extend(true, {}, this.model.get('params'));
            _.each(attributes_settings, function (param) {
                params[param.param_name] = vc.atts.parse.call(this, param);
            }, this);
            return params;
        },
        getCurrentParams: function() {
            var attributes_settings = this.mapped_params,
                params = jQuery.extend(true, {}, this.model.get('params'));
            _.each(attributes_settings, function (param) {
                if(_.isUndefined(params[param.param_name])) params[param.param_name] = '';
                if(param.type === "textarea_html") params[param.param_name] = params[param.param_name].replace(/\n/g, '');
            }, this);
            return params;
        },
        show:function () {
            this.render();
            this.$el.modal('show');
        },
        _killEditor:function () {
            if(!_.isUndefined(window.tinyMCE)) {
                $('textarea.textarea_html', this.$el).each(function () {
                    var id = $(this).attr('id');
                    window.tinyMCE.execCommand("mceRemoveControl", true, id);
                });
            }
        },
        dataNotChanged: function() {
            var current_params = this.getCurrentParams(),
                new_params = this.getParams();
            return _.isEqual(current_params, new_params);
        },
        askSaveData:function () {
            if (this.data_saved || this.dataNotChanged() || confirm(window.i18nLocale.if_close_data_lost)) {
                this._killEditor();
                this.data_saved = true;
                return true;
            }
            return false;
        },
        close:function () {
            if (this.askSaveData()) {
                this.$el.modal('hide');
            }
        }
    });
>>>>>>> master

    var VisualComposer = Backbone.View.extend({
        el:$('#wpb_visual_composer'),
        views:{},
        events:{
            "click #wpb-add-new-row":'createRow',
<<<<<<< HEAD
            'click #vc_post-settings-button': 'editSettings',
            'click #vc_add-new-element, .vc_add-element-button, .vc_add-element-not-empty-button':'addElement',
            'click .vc_add-text-block-button':'addTextBlock',
            'click .wpb_switch-to-composer':'switchComposer',
            'click #vc_templates-editor-button': 'openTemplatesEditor',
            'click [data-template_name]':'loadDefaultTemplate',
            'click #wpb-save-post':'save',
            'click .vc_control-preview':'preview'
        },
        initialize:function () {
            this.accessPolicy = $('.vc_js_composer_group_access_show_rule').val();
=======
            "click #wpb-custom-post-css":'showPostCustomCss',
            'click #wpb-add-new-element, .add-element-to-layout':'addElement',
            'click .add-text-block-to-content':'addTextBlock',
            'click .wpb_switch-to-composer':'switchComposer',
            'click #wpb_save_template_button':'saveTemplate',
            'click [data-template_id]':'loadTemplate',
            'click .wpb_remove_template':'removeTemplate',
            'click #wpb-convert':'convert',
            'click #wpb-save-post':'save'
        },
        initialize:function () {
            this.accessPolicy = $('.wpb_js_composer_group_access_show_rule').val();
>>>>>>> master
            if (this.accessPolicy == 'no') return false;
            this.buildRelevance();
            _.bindAll(this, 'switchComposer', 'dropButton', 'processScroll', 'updateRowsSorting', 'updateElementsSorting');
            Shortcodes.bind('add', this.addShortcode, this);
            Shortcodes.bind('destroy', this.checkEmpty, this);
            Shortcodes.bind('reset', this.addAll, this);
            this.render();
        },
        render:function () {
<<<<<<< HEAD
            var front = '';
            if (this.accessPolicy !== 'only') {
                if(vc_frontend_enabled) front = '<span class="vc_spacer"></span><a class="wpb_switch-to-front-composer" href="' + $('#wpb-edit-inline').attr('href') +'">' + window.i18nLocale.main_button_title_frontend_editor + '</a>';
                this.$buttonsContainer = $('<div class="composer-switch"><span class="logo-icon"></span><span class="vc_spacer"></span><a class="wpb_switch-to-composer" href="#">' + window.i18nLocale.main_button_title_backend_editor + '</a>' + front + '</div>').insertAfter('div#titlediv');
=======
            if (this.accessPolicy !== 'only') {
                this.$buttonsContainer = $('<div class="button-primary composer-switch"><span class="icon"></span><span class="vc-spacer"></span><a class="wpb_switch-to-front-composer" href="' + $('#wpb-edit-inline').attr('href') +'">' + window.i18nLocale.main_button_title_frontend_editor + '</a><span class="vc-spacer"></span><a class="wpb_switch-to-composer" href="#">' + window.i18nLocale.main_button_title_backend_editor + '</a></div>').insertAfter('div#titlediv');
>>>>>>> master
                // this.$switchButton = $('<a class="wpb_switch-to-composer button-primary" href="#">' + window.i18nLocale.main_button_title + '</a>').insertAfter('div#titlediv').wrap('<p class="composer-switch" />');
                this.$switchButton = this.$buttonsContainer.find('.wpb_switch-to-composer');
                this.$switchButton.click(this.switchComposer);
            }
            this.$metablock_content = $('.metabox-composer-content');
            this.$content = $("#visual_composer_content");
            this.$post = $('#postdivrich');
            this.$vcStatus = $('#wpb_vc_js_status');
<<<<<<< HEAD
            this.$loading_block = $('#vc_logo');
            vc.add_element_block_view = new vc.AddElementBlockViewBackendEditor({el: '#vc_add-element-dialog'});
            vc.edit_element_block_view = new vc.EditElementPanelView({el: '#vc_properties-panel'});
            vc.templates_editor_view = new vc.TemplatesEditorPanelViewBackendEditor({el: '#vc_templates-editor'});
            vc.post_settings_view = new vc.PostSettingsPanelViewBackendEditor({el: '#vc_post-settings-panel'});
            this.setSortable();
            this.setDraggable();
            vc.is_mobile = $('body.mobile').length > 0;
            vc.saved_custom_css = $('#wpb_custom_post_css_field').val();
            vc.updateSettingsBadge();
=======
            this.$loading_block = $('.vc_loading_block');
            this.setSortable();
            this.setDraggable();
            vc.is_mobile = $('body.mobile').length > 0
>>>>>>> master
            return this;
        },
        addAll:function () {
            this.views = {};
            this.$content.removeClass('loading').html('');
<<<<<<< HEAD
            this.addChild(false);
            this.checkEmpty();
            this.$loading_block.removeClass('vc_ajax-loading');
            this.$metablock_content.removeClass('vc_loading-shortcodes');
        },
        addChild: function(parent_id) {
            _.each(vc.shortcodes.where({parent_id: parent_id}), function (shortcode) {
                this.appendShortcode(shortcode);
                this.setSortable();
                this.addChild(shortcode.get('id'));
            }, this);
=======
            Shortcodes.each(function (shortcode) {
                this.appendShortcode(shortcode);
                this.setSortable();
            }, this);
            // Check if old version of layout.
            if (this.$content.find('> [data-element_type]:not(.wpb_vc_row)').length > 0) {
                $('#wpb-convert-message').show();
            } else {
                $('#wpb-convert-message').hide();
            }

            this.checkEmpty();
            this.$loading_block.hide();
>>>>>>> master
        },
        getView:function (model) {
            var view;
            if (_.isObject(vc.map[model.get('shortcode')]) && _.isString(vc.map[model.get('shortcode')].js_view) && vc.map[model.get('shortcode')].js_view.length) {
                view = new window[window.vc.map[model.get('shortcode')].js_view]({model:model});
            } else {
                view = new ShortcodeView({model:model});
            }
            model.set({view: view});
            return view;
        },
        setDraggable:function () {
            $('#wpb-add-new-element, #wpb-add-new-row').draggable({
                helper:function () {
                    return $('<div id="drag_placeholder"></div>').appendTo('body');
                },
                zIndex:99999,
                // cursorAt: { left: 10, top : 20 },
                cursor:"move",
                // appendTo: "body",
                revert:"invalid",
                start:function (event, ui) {
                    $("#drag_placeholder").addClass("column_placeholder").html(window.i18nLocale.drag_drop_me_in_column);
                }
            });
            this.$content.droppable({
                greedy:true,
                accept:".dropable_el,.dropable_row",
                hoverClass:"wpb_ui-state-active",
                drop:this.dropButton
            });
        },
        dropButton:function (event, ui) {
            if (ui.draggable.is('#wpb-add-new-element')) {
                this.addElement();
            } else if (ui.draggable.is('#wpb-add-new-row')) {
                this.createRow();
            }
        },
        appendShortcode:function (model) {
            var view = this.getView(model),
                position = model.get('order'),
                $element_to_add = model.get('parent_id') !== false ?
                    this.views[model.get('parent_id')].$content
                    :
                    this.$content;
            this.views[model.id] = view;
            if (model.get('parent_id')) {
                var parent_view = this.views[model.get('parent_id')];
                parent_view.unsetEmpty();
            }
            $element_to_add.append(view.render().el);
            view.ready();

            view.changeShortcodeParams(model); // Refactor
            view.checkIsEmpty();
            this.setNotEmpty();
        },
        addShortcode: function (model) {
            var view = this.getView(model),
                position = model.get('order'),
                $element_to_add = model.get('parent_id') !== false ?
                    this.views[model.get('parent_id')].$content
                    :
                    this.$content;
            view.use_default_content = model.get('cloned') !== true;
            this.views[model.id] = view;
            var before_shortcode = _.last(Shortcodes.filter(function (shortcode) {
                return shortcode.get('parent_id') === this.get('parent_id') && parseFloat(shortcode.get('order')) < parseFloat(this.get('order'));
            }, model));
            if (before_shortcode) {
                view.render().$el.insertAfter('[data-model-id=' + before_shortcode.id + ']');
            } else {
                $element_to_add.prepend(view.render().el);
            }

            if (model.get('parent_id')) {
                var parent_view = this.views[model.get('parent_id')];
                parent_view.checkIsEmpty();
            }
            model.trigger('change:params', model);
            view.ready();
            this.setSortable();
            this.setNotEmpty();
        },
<<<<<<< HEAD
=======
        /**
         * Remove template from server database.
         * @param e - Event object
         */
        removeTemplate:function (e) {
            e.preventDefault();
            var $button = $(e.currentTarget);
            var template_name = $button.closest('.wpb_template_li').find('a').text();
            var answer = confirm(window.i18nLocale.confirm_deleting_template.replace('{template_name}', template_name));
            if (answer) {
                // this.reloadTemplateList(data);
                $.post(window.ajaxurl, {
                    action:'wpb_delete_template',
                    template_id:$button.attr('rel')
                });
                $button.closest('.wpb_template_li').remove();
            }
        },
        /**
         * Load saved template from server.
         * @param e - Event object
         */
        loadTemplate:function (e) {
            e.preventDefault();
            var $button = $(e.currentTarget);
            $.ajax({
                type:'POST',
                url:window.ajaxurl,
                data:{
                    action:'wpb_load_template_shortcodes',
                    template_id:$button.attr('data-template_id')
                }
            }).done(function (shortcodes) {
                    _.each(vc.filters.templates, function (callback) {
                        shortcodes = callback(shortcodes);
                    });
                    vc.storage.append(shortcodes);
                    Shortcodes.fetch({reset: true});
                });
        },
        convert:function (e) {
            e.preventDefault();
            if (confirm((window.i18nLocale.are_you_sure_convert_to_new_version)))
                $.ajax({
                    type:'POST',
                    url:window.ajaxurl,
                    data:{
                        action:'wpb_get_convert_elements_backend_html',
                        data:vc.storage.getContent()
                    },
                    context:this
                }).done(function (response) {
                        vc.storage.setContent(response);
                        vc.storage.checksum = false; // To be sure that data will fetched from editor.
                        Shortcodes.fetch({reset: true});
                        $('#wpb_vc_js_interface_version').val('2');
                        $('#wpb-convert-message').hide();
                    });
        },
        /**
         * Save current shortcode design as template with title.
         * @param e - Event object
         */
        saveTemplate:function (e) {
            e.preventDefault();
            var name = window.prompt(window.i18nLocale.please_enter_templates_name, ''),
                shortcodes = '',
                data;

            if (_.isString(name) && name.length) {
                shortcodes = vc.storage.getContent();
                data = {
                    action:'wpb_save_template',
                    template:shortcodes,
                    template_name:name
                };

                this.reloadTemplateList(data);
            }
        },
        reloadTemplateList:function (data) {
            $.post(window.ajaxurl, data, function (html) {
                $('.wpb_templates_list').html(html);
            });
        },
>>>>>>> master
        addTextBlock:function (e) {
            e.preventDefault();
            var row = Shortcodes.create({shortcode:'vc_row'}),
                column = Shortcodes.create({shortcode:'vc_column', params:{width:'1/1'}, parent_id:row.id, root_id:row.id }),
                text_block = Shortcodes.create({shortcode:'vc_column_text', params:vc.getDefaults('vc_column_text'), parent_id:column.id, root_id:row.id });
            return text_block;
        },
        /**
         * Create row
         */
        createRow:function () {
            var row = Shortcodes.create({shortcode:'vc_row'});
            Shortcodes.create({shortcode:'vc_column', params:{width:'1/1'}, parent_id:row.id, root_id:row.id });
            return row;
        },
        /**
         * Add Element with a help of modal view.
         */
        addElement:function (e) {
<<<<<<< HEAD
          _.isObject(e) && e.preventDefault();
          vc.add_element_block_view.render(false);
        },
        openTemplatesEditor: function(e) {
          e && e.preventDefault();
          vc.templates_editor_view.render().show();
        },
        loadDefaultTemplate: function(e) {
          e && e.preventDefault();
          vc.templates_editor_view.loadDefaultTemplate(e);
          // $("#vc_no-content-helper").remove(); // TODO check P vs S
        },
        editSettings: function(e) {
          e && e.preventDefault();
          vc.post_settings_view.render().show();
        },
        sortingStarted:function (event, ui) {
            $('#visual_composer_content').addClass('vc_sorting-started');
        },
        sortingStopped:function (event, ui) {
            $('#visual_composer_content').removeClass('vc_sorting-started');
=======
            if (_.isObject(e)) e.preventDefault();
            new ElementBlockView({model:{position_to_add:'end'}}).show(this);
        },
        showPostCustomCss: function(e) {
          if (_.isObject(e)) e.preventDefault();
          new PostCustomCssBlockView().show();

        },
        sortingStarted:function (event, ui) {
            $('#visual_composer_content').addClass('sorting-started');
        },
        sortingStopped:function (event, ui) {
            $('#visual_composer_content').removeClass('sorting-started');
>>>>>>> master
        },
        updateElementsSorting:function (event, ui) {
            _.defer(function (app, event, ui) {
                var $current_container = ui.item.parent().closest('[data-model-id]'),
                    parent = $current_container.data('model'),
                    model = ui.item.data('model'),
                    models = app.views[parent.id].$content.find('> [data-model-id]'),
                    i = 0;
                // Change parent if block moved to another container.
                if (!_.isNull(ui.sender)) {
                    var old_parent_id = model.get('parent_id');
                    store.lock();
                    model.save({parent_id:parent.id});
                    app.views[old_parent_id].checkIsEmpty();
                    app.views[parent.id].checkIsEmpty();
                }
                models.each(function () {
                    var shortcode = $(this).data('model');
                    store.lock();
                    shortcode.save({'order':i++});
                });
                model.save();
            }, this, event, ui);

        },
        updateRowsSorting:function () {
            _.defer(function (app) {
                var $rows = app.$content.find('> .wpb_vc_row');
                $rows.each(function () {
                    var index = $(this).index();
                    if ($rows.length - 1 > index) store.lock();
                    $(this).data('model').save({'order':index});
                });
            }, this);
        },
<<<<<<< HEAD
        renderPlaceholder: function(event, element) {
          var tag = $(element).data('element_type'),
            $helper = $('<div class="vc_helper vc_helper-' + tag + '"><i class="vc_element-icon'
              + ( vc.map[tag].icon ? ' ' + vc.map[tag].icon : '' )
              + '"></i> ' + vc.map[tag].name + '</div>').prependTo('body');
          return $helper;
        },
=======
>>>>>>> master
        setSortable:function () {
            var that = this;
            $('.wpb_main_sortable').sortable({
                forcePlaceholderSize:true,
                placeholder:"widgets-placeholder",
                // cursorAt: { left: 10, top : 20 },
                cursor:"move",
                items:"> .wpb_vc_row", // wpb_sortablee
                handle:'.column_move',
                distance:0.5,
                start:this.sortingStarted,
                stop:this.sortingStopped,
                update:this.updateRowsSorting,
                over:function (event, ui) {
                    ui.placeholder.css({maxWidth:ui.placeholder.parent().width()});
                }
            });
            $('.wpb_column_container').sortable({
<<<<<<< HEAD
                forcePlaceholderSize: true,
                forceHelperSize: false,
                connectWith:".wpb_column_container",
                placeholder:"vc_placeholder",
                items:"> div.wpb_sortable", //wpb_sortablee
                helper: this.renderPlaceholder,
                distance: 3,
                scroll: true,
                scrollSensitivity: 70,
                cursor: 'move',
                cursorAt: {top: 20, left: 16},
                tolerance:'pointer',
                start:function () {
                    $('#visual_composer_content').addClass('vc_sorting-started');
                    $('.vc_not_inner_content').addClass('dragging_in');
                },
                stop:function (event, ui) {
                    $('#visual_composer_content').removeClass('vc_sorting-started');
                    $('.dragging_in').removeClass('dragging_in');
                    var tag = ui.item.data('element_type'),
                        parent_tag = ui.item.parent().closest('[data-element_type]').data('element_type'),
                        allowed_container_element = !_.isUndefined(vc.map[parent_tag].allowed_container_element) ? vc.map[parent_tag].allowed_container_element : true;
                    if (!vc.check_relevance(parent_tag, tag)) {
                        $(this).sortable('cancel');
                    }
                    if (vc.map[ui.item.data('element_type')].is_container && !(allowed_container_element === true || allowed_container_element === ui.item.data('element_type').replace(/_inner$/, ''))) { // && ui.item.hasClass('wpb_container_block')
                        $(this).sortable('cancel');
                    }
                    $('.vc_sorting-empty-container').removeClass('vc_sorting-empty-container');
                },
                update:this.updateElementsSorting,
                over:function (event, ui) {
=======
                forcePlaceholderSize:true,
                connectWith:".wpb_column_container",
                placeholder:"widgets-placeholder",
                // cursorAt: { left: 10, top : 20 },
                cursor:"move",
                items:"> div.wpb_sortable", //wpb_sortablee
                distance:0.5,
                tolerance:'pointer',
                start:function () {
                    $('#visual_composer_content').addClass('sorting-started');
                    $('.vc_not_inner_content').addClass('dragging_in');
                },
                stop:function (event, ui) {
                    $('#visual_composer_content').removeClass('sorting-started');
                    $('.dragging_in').removeClass('dragging_in');
                },
                update:this.updateElementsSorting,
                over:function (event, ui) {
                    var tag = ui.item.data('element_type'),
                        parent_tag = ui.placeholder.closest('[data-element_type]').data('element_type'),
                        allowed_container_element = !_.isUndefined(vc.map[parent_tag].allowed_container_element) ? vc.map[parent_tag].allowed_container_element : true;
                    if (!vc.check_relevance(parent_tag, tag)) {
                        ui.placeholder.addClass('hidden-placeholder');
                        return false;
                    }
                    if (vc.map[ui.item.data('element_type')].is_container && !(allowed_container_element === true || allowed_container_element === ui.item.data('element_type').replace(/_inner$/, ''))) {
                        ui.placeholder.addClass('hidden-placeholder');
                        return false;
                    }
                    ui.placeholder.removeClass('hidden-placeholder');
                    ui.placeholder.css({maxWidth:ui.placeholder.parent().width()});
                },
                beforeStop:function (event, ui) {
>>>>>>> master
                    var tag = ui.item.data('element_type'),
                        parent_tag = ui.placeholder.closest('[data-element_type]').data('element_type'),
                        allowed_container_element = !_.isUndefined(vc.map[parent_tag].allowed_container_element) ? vc.map[parent_tag].allowed_container_element : true;
                    if (!vc.check_relevance(parent_tag, tag)) {
<<<<<<< HEAD
                        ui.placeholder.addClass('vc_hidden-placeholder');
                        return false;
                    }
                    if (vc.map[ui.item.data('element_type')].is_container && !(allowed_container_element === true || allowed_container_element === ui.item.data('element_type').replace(/_inner$/, ''))) {
                        ui.placeholder.addClass('vc_hidden-placeholder');
                        return false;
                    }
                    if(ui.sender.length && !ui.sender.find('[data-element_type]:visible').length) {
                      ui.sender.addClass('vc_sorting-empty-container');
                    }
                    ui.placeholder.removeClass('vc_hidden-placeholder'); // .parent().removeClass('vc_empty-container');
                    ui.placeholder.css({maxWidth:ui.placeholder.parent().width()});
=======
                        $('#visual_composer_content').removeClass('sorting-started');
                        return false;
                    }
                    if (vc.map[ui.item.data('element_type')].is_container && !(allowed_container_element === true || allowed_container_element === ui.item.data('element_type').replace(/_inner$/, ''))) { // && ui.item.hasClass('wpb_container_block')
                        $('#visual_composer_content').removeClass('sorting-started');
                        return false;
                    }
>>>>>>> master
                }
            });
            return this;
        },
        setNotEmpty:function () {
<<<<<<< HEAD
            // this.$metablock_content.removeClass('empty-composer');
            $('#vc_no-content-helper').addClass('vc_not-empty');
        },
        setIsEmpty:function () {
            // this.$metablock_content.addClass('empty-composer');
            $('#vc_no-content-helper').removeClass('vc_not-empty')
=======
            this.$metablock_content.removeClass('empty-composer');
        },
        setIsEmpty:function () {
            this.$metablock_content.addClass('empty-composer');
>>>>>>> master
        },
        checkEmpty:function (model) {
            if (_.isObject(model) && model.get('parent_id') !== false && model.get('parent_id') != model.id) {
                var parent_view = this.views[model.get('parent_id')];
                parent_view.checkIsEmpty();
            }
            if (this.$content.find('[data-element_type]').length === 0) {
                this.setIsEmpty();
            } else {
                this.setNotEmpty();
            }
        },
        switchComposer:function (e) {
            if (_.isObject(e)) e.preventDefault();
            if (this.status == 'shown') {
<<<<<<< HEAD
              if (this.accessPolicy !== 'only') {
                !_.isUndefined(this.$switchButton) && this.$switchButton.text(window.i18nLocale.main_button_title_backend_editor);
                !_.isUndefined(this.$buttonsContainer) && this.$buttonsContainer.removeClass('vc_backend-status');
              }
              this.close();
              this.status = 'closed';
            } else {
              if (this.accessPolicy !== 'only') {
                !_.isUndefined(this.$switchButton) && this.$switchButton.text(window.i18nLocale.main_button_title_revert);
                !_.isUndefined(this.$buttonsContainer) && this.$buttonsContainer.addClass('vc_backend-status');
              }
              this.show();
=======
                if (!_.isUndefined(this.$switchButton)) this.$switchButton.text(window.i18nLocale.main_button_title);
                this.close();
                this.status = 'closed';
            } else {
                if (!_.isUndefined(this.$switchButton)) this.$switchButton.text(window.i18nLocale.main_button_title_revert);
                this.show();
>>>>>>> master
                this.status = 'shown';

            }
        },
        show:function () {
            this.$el.show();
            this.$post.hide();
            this.$vcStatus.val("true");
            this.navOnScroll();
            if (vc.storage.isContentChanged()) {
                vc.app.setLoading();
                vc.app.views = {};

                window.setTimeout(function () {
                    Shortcodes.fetch({reset: true});
                }, 100);
            }
        },
        setLoading:function () {
            this.setNotEmpty();
<<<<<<< HEAD
            this.$loading_block.addClass('vc_ajax-loading');
            this.$metablock_content.addClass('vc_loading-shortcodes');
        },
        close:function () {
            this.$vcStatus.val("false");
            // if (this.$switchButton !== undefined) this.$switchButton.html(window.i18nLocale.main_button_title);
=======
            $('#wpb-convert-message').hide();
            this.$loading_block.show();
        },
        close:function () {
            this.$vcStatus.val("false");
            if (this.$switchButton !== undefined) this.$switchButton.html(window.i18nLocale.main_button_title);
>>>>>>> master
            this.$el.hide();
            this.$post.show();
        },
        checkVcStatus:function () {
            if (this.$vcStatus.val() === 'true' || this.accessPolicy === 'only') {
                this.switchComposer();
            }
        },
        setNavTop:function () {
<<<<<<< HEAD
          this.navTop = this.$nav.length && this.$nav.offset().top - 28;
=======
            this.navTop = $('#wpb_visual_composer-elements').length && $('#wpb_visual_composer-elements').offset().top - 28;

>>>>>>> master
        },
        save:function () {
            $('#wpb-save-post').text(window.i18nLocale.loading);
            $('#publish').click();
        },
<<<<<<< HEAD
        preview:function() {
            $('#post-preview').click();
        },
        navOnScroll:function () {
            var $win = $(window);
            this.$nav = $('#vc_navbar'); // $('#wpb_visual_composer-elements');
            this.setNavTop();
=======
        navOnScroll:function () {
            var $win = $(window);
            this.setNavTop();
            this.$nav = $('#wpb_visual_composer-elements');
>>>>>>> master
            this.processScroll();
            $win.unbind('scroll.composer').on('scroll.composer', this.processScroll);
        },
        processScroll:function (e) {
<<<<<<< HEAD
            if( !this.navTop || this.navTop < 0) {
                this.setNavTop();
            }
            this.scrollTop = $(window).scrollTop() + 80;
            if ( this.navTop > 0 && this.scrollTop >= this.navTop && !this.isFixed) {
                this.isFixed = 1;
                this.$nav.addClass('vc_subnav-fixed');
            } else if ( this.scrollTop <= this.navTop && this.isFixed) {
                this.isFixed = 0;
                this.$nav.removeClass('vc_subnav-fixed');
=======
            this.scrollTop = $(window).scrollTop();
            if (this.scrollTop >= this.navTop && !this.isFixed) {
                this.isFixed = 1;
                this.$nav.addClass('subnav-fixed');
            } else if (this.scrollTop <= this.navTop && this.isFixed) {
                this.isFixed = 0;
                this.$nav.removeClass('subnav-fixed');
>>>>>>> master
            }
        },
        buildRelevance:function () {
            vc.shortcode_relevance = {};
            _.map(vc.map, function (object) {
                if (_.isObject(object.as_parent) && _.isString(object.as_parent.only)) {
                    vc.shortcode_relevance['parent_only_' + object.base] = object.as_parent.only.replace(/\s/, '').split(',');
                }
                if (_.isObject(object.as_parent) && _.isString(object.as_parent.except)) {
                    vc.shortcode_relevance['parent_except_' + object.base] = object.as_parent.except.replace(/\s/, '').split(',');
                }
                if (_.isObject(object.as_child) && _.isString(object.as_child.only)) {
                    vc.shortcode_relevance['child_only_' + object.base] = object.as_child.only.replace(/\s/, '').split(',');
                }
                if (_.isObject(object.as_child) && _.isString(object.as_child.except)) {
                    vc.shortcode_relevance['child_except_' + object.base] = object.as_child.except.replace(/\s/, '').split(',');
                }
            });
            /**
             * Check parent/children relationship between two tags
             * @param tag
             * @param related_tag
             * @return boolean - Returns true if relevance is positive
             */
            vc.check_relevance = function (tag, related_tag) {
                if (_.isArray(vc.shortcode_relevance['parent_only_' + tag]) && !_.contains(vc.shortcode_relevance['parent_only_' + tag], related_tag)) {
                    return false;
                }
                if (_.isArray(vc.shortcode_relevance['parent_except_' + tag]) && _.contains(vc.shortcode_relevance['parent_except_' + tag], related_tag)) {
                    return false;
                }
                if (_.isArray(vc.shortcode_relevance['child_only_' + related_tag]) && !_.contains(vc.shortcode_relevance['child_only_' + related_tag], tag)) {
                    return false;
                }
                if (_.isArray(vc.shortcode_relevance['child_except_' + related_tag]) && _.contains(vc.shortcode_relevance['child_except' + related_tag], tag)) {
                    return false;
                }
                return true;
            };
        }
    });
    $(function(){
        if ($('#wpb_visual_composer').is('div')) {
            var app = vc.app = new VisualComposer();
            vc.app.checkVcStatus();
        }
    });


})(window.jQuery);