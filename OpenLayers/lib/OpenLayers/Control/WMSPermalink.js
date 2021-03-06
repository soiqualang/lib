/* Copyright (c) 2006 MetaCarta, Inc., published under a modified BSD license.
 * See http://svn.openlayers.org/trunk/openlayers/repository-license.txt 
 * for the full text of the license. */


/**
 * @class
 * 
 * @requires OpenLayers/Control.js
 */
OpenLayers.Control.WMSPermalink = OpenLayers.Class.create();
OpenLayers.Control.WMSPermalink.prototype = 
  OpenLayers.Class.inherit( OpenLayers.Control, {

    /** @type DOMElement */
    element: null,
    
    /** @type String */
    base: '',

    /**
     * @constructor
     * 
     * @param {DOMElement} element
     * @param {String} base
     */
    initialize: function(element, base) {
        OpenLayers.Control.prototype.initialize.apply(this, arguments);
        this.element = OpenLayers.Util.getElement(element);        
        if (base) {
            this.base = base;
        }
    },

    /**
     * 
     */
    destroy: function()  {
        if (this.element.parentNode == this.div) {
            this.div.removeChild(this.element);
        }
        this.element = null;

        this.map.events.unregister('moveend', this, this.updateLink);

        OpenLayers.Control.prototype.destroy.apply(this, arguments); 
    },

    /** Set the map property for the control. 
     * 
     * @param {OpenLayers.Map} map
     */
    setMap: function(map) {
        OpenLayers.Control.prototype.setMap.apply(this, arguments);

        //make sure we have an arg parser attached
        for(var i=0; i< this.map.controls.length; i++) {
            var control = this.map.controls[i];
            if (control.CLASS_NAME == "OpenLayers.Control.ArgParser") {
                break;
            }
        }
        if (i == this.map.controls.length) {
            this.map.addControl(new OpenLayers.Control.ArgParser());       
        }

    },

    /**
     * @type DOMElement
     */    
    draw: function() {
        OpenLayers.Control.prototype.draw.apply(this, arguments);
          
        if (!this.element) {
            this.div.className = this.displayClass;
            this.element = document.createElement("a");
            this.element.style.fontSize="smaller";
            this.element.innerHTML = "Permalink";
            this.element.href="";
            this.div.appendChild(this.element);
        }
        this.map.events.register('moveend', this, this.updateLink);
        return this.div;
    },
   
    /**
     * 
     */
    updateLink: function() {
        var center = this.map.getCenter();
        var zoom = "zoom=" + this.map.getZoom(); 
        var lat = "lat=" + Math.round(center.lat*100000)/100000;
        var lon = "lon=" + Math.round(center.lon*100000)/100000;

        var layers = "layers=";
        /*for(var i=0; i< this.map.layers.length; i++) {
            var layer = this.map.layers[i];

            if (layer.isBaseLayer) {
                layers += (layer == this.map.baseLayer) ? "B" : "0";
            } else {
                layers += (layer.getVisibility()) ? "T" : "F";           
            }
        }*/
		for(var i=0; i< this.map.layers.length; i++) {
            var layer = this.map.layers[i];

            if (layer.isBaseLayer) {
                layers += (layer == this.map.baseLayer) ? "||B|" : "||0|";
				layers += layer.WMSinfo[0]+'|'+encodeURIComponent(layer.WMSinfo[1])+'|'+encodeURIComponent(layer.WMSinfo[2]);
            } else {
                layers += (layer.getVisibility()) ? "||T|" : "||F|";  
				layers += layer.WMSinfo[0]+'|'+encodeURIComponent(layer.WMSinfo[1])+'|'+encodeURIComponent(layer.WMSinfo[2]);         
            }
			var wmsLayerString ='';
			for(var u=0; u< layer.aWMSLayers.length; u++) {
				var sLayer = layer.aWMSLayers[u];
				//alert(sLayer);
				wmsLayerString +='$$$'+sLayer.join('@');
			}
			layers += '|'+encodeURIComponent(wmsLayerString);
        }
        var href = this.base + "?" + lat + "&" + lon + "&" + zoom + 
                                   "&" + layers; 
        this.element.href = href;
		this.element.WMSinfo = this.map.layers[0].WMSinfo;
		/*this.element.onclick = function( ){
			alert (this.WMSinfo);
		};*/
		
    }, 

    /** @final @type String */
    CLASS_NAME: "OpenLayers.Control.WMSPermalink"
});
