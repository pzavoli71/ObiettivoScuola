(function() {

function Tabs() {
	
	this.addTab = function(NomeTab, Desc, href) {
		n = '';
		if ( $('#tab-'+NomeTab).length > 0) {
			// Esiste già una tab con questo nome, ne creo un'altra con un progressivo
			n = 2;
			NomeTab2 = NomeTab + "-" + n;
			while ($('#tab-'+NomeTab2).length > 0) {
				n++;
				NomeTab2 = NomeTab + "-" + n;
				if ( n > 10) {
					alert('Troppe finestre apert con questo nome!');
					return false;
				}				
			}
			NomeTab += "-" + n;
		}
		s = "<div id='tab-" + NomeTab + "' class='tab-container active'><iframe id='frame-"+ NomeTab + "' class='frame-container'></iframe></div>";
		$('#main-container > .tabs-container').append(s);
		
		if ( n != '') 
			n = ' (' + n + ')';
		s = "<li id='li-" + NomeTab + "' class='li-tab' href='" + href +"'>" + Desc + n + "<i class='tab-chiudi far fa-window-close' title='Chiudi' onclick='return Tabs.closeTab(\"" + NomeTab + "\")'></i></li>"; 
		$('#tabs-header > ul').append(s);
		
		$('#li-' + NomeTab).click(function() {
			Tabs.activateTab(NomeTab);
		});
		
		if ( href && href != '') {
			//$('#tab-' + NomeTab).load(href);			
			$('#frame-' + NomeTab).attr('src', href);			
		}	
		Tabs.activateTab(NomeTab);	
		return false;	
	}
	
	this.activateTab = function(NomeTab) {
		$(".tab-container").removeClass("active");
		$(".li-tab").removeClass("active");
		$('#tab-' + NomeTab).addClass("active");
		$('#li-' + NomeTab).addClass("active");
	}

	this.closeTab = function(NomeTab) {
		postabactive = null;
		postabdeleted = 0;
		i = 0;
		$('.li-tab').each(function() {
			if ( $(this).hasClass('active')) {
				postabactive = i;
			}
			if ( $(this).attr('id') == 'li-' + NomeTab) {
				postabdeleted = i;
			}
			i++;
		});
		$('#tab-' + NomeTab).remove();
		$('#li-' + NomeTab).remove();
		
		if ( postabactive == postabdeleted) {			
			if ( postabactive > 0) {
				NomeTabNew = $($('.li-tab')[postabactive - 1]).attr('id');
				Tabs.activateTab(NomeTabNew.substring(3));
			} else {
				NomeTabNew = $($('.li-tab')[postabactive]).attr('id');
				if ( NomeTabNew != undefined)
					Tabs.activateTab(NomeTabNew.substring(3));				
			}
		}
		return false;
	}
	
	// Legge dal parametro href del tag 'a' l'url che poi verrà aperto 
	// Nel tab corrente
	this.openLinkInCurrentTab = function(obj) {
		href = $(obj).attr('href');
		$this = $(obj);
		fine = false;
		while ( !fine) {
			//alert($this.attr('class'));
			if ( $this.hasClass('tab-container')) {
				if ( href && href != '') {
					Tabs.openInTab($this.attr('id'), href);
					return false;
				}
			}
			$this = $this.parent();
			if ( $this == null || $this == undefined || $this.length == 0)
				fine = true;
		}
	}

	this.openInTab = function(IdTab, href) {
		if ( href && href != '') {
			$('#' + IdTab).load(href);			
			document.getElementById(IdTab).scrollIntoView();
		}			
	}
	
	this.findContainer = function(obj) {
		$this = $(obj);
		fine = false;
		while ( !fine) {
			if ( $this.hasClass('tab-container')) {
				return $this;
			}
			$this = $this.parent();
			if ( $this == null || $this == undefined || $this.length == 0)
				fine = true;
		}
		return null;
	}
	
	this.showLoading = function() {
		$('#divloading').show();
	};

	this.hideLoading = function() {
		$('#divloading').hide();
	}

	this.eseguiComando = function(href, nomecomando, chiave, parametri, richiestaComando, callback) {
		var dati = parametri;
		dati['cisNomeComandoAjax'] = nomecomando;
		dati['GetXML'] = true;
		if ( typeof richiestaComando == 'function') {
			if ( !richiestaComando(nomecomando, chiave, dati, href, callback)) {
				//alert('Comando annullato');
				return;
			}
		}
		if ( ajaxrequest )
			ajaxrequest.abort();
		this.showLoading();
		var that = this;
		ajaxrequest = $.ajax({
			url: href,
			cache: false,
			type:'post',
			data: dati,
			dataType: 'xml'
		}).done(function( data ) {
			that.hideLoading();
			if ( typeof callback == 'function')
				callback(nomecomando, chiave, data);
		})
	};

	};
	Tabs = new Tabs();
	window['Tabs'] = Tabs;
})();	