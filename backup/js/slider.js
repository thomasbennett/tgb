{\rtf1\ansi\ansicpg1252\cocoartf1038\cocoasubrtf320
{\fonttbl\f0\fmodern\fcharset0 Courier;}
{\colortbl;\red255\green255\blue255;}
\margl1440\margr1440\vieww9000\viewh8400\viewkind0
\deftab720
\pard\pardeftab720\ql\qnatural

\f0\fs24 \cf0 /* String.prototype */\
\
String.prototype.changeExtension = function(to)\
\{\
	return this.replace(/^(.*?)(\\.([a-z0-9-_]\{1,12\}))?$/, '$1.' + to);\
\}\
\
/* Items */\
\
var Item = function(id)\
\{\
	this.id = id;\
	this.setupButtons();\
\};\
Item.prototype =\
\{\
	append: false,\
	\
	setupButtons: function()\
	\{\
		var self = this;\
		\
		s(['a#' + this.id + '-prev',\
		   'a#' + this.id + '-next']).set('onclick', function()\
		\{\
			self.reload(this, false);\
			return false;\
		\});\
		s('a#' + this.id + '-more').set('onclick', function()\
		\{\
			self.reload(this, true);\
			return false;\
		\});\
	\},\
	reload: function(anchor, append)\
	\{\
		var self = this;\
		\
		anchor.className += ' loading';\
		Ajax.submit(anchor.href.changeExtension('ajax'), \{ callback: function()\
		\{\
			if(append)\
			\{\
				s('#' + self.id + '-pagination').remove();\
				document.getElementById(self.id).innerHTML += this.responseText;\
			\}\
			else\
			\{\
				document.getElementById(self.id).innerHTML = this.responseText;\
			\}\
			self.setupButtons();\
		\}\});\
	\}\
\};\
var Items =\
\{\
	init: function(items)\
	\{\
		for(var i = 0, item; i < items.length; i++)\
		\{\
			if(document.getElementById(items[i]))\
			\{\
				item = new Item(items[i]);\
			\}\
		\}\
	\}\
\};\
\
/* Comments */\
\
var Comments =\
\{\
	init: function()\
	\{\
		this.setupItems();\
		this.setupSlider();\
	\},\
	setupItems: function()\
	\{\
		var self = this;\
		\
		this.items = [];\
		s('ul#comments li.comment').run(function()\
		\{\
			var li = this;\
			s(this).s('p.reply a').run(function()\
			\{\
				self.items[self.items.length] = new Comment(li, this);\
			\});\
		\});\
	\},\
	setupSlider: function()\
	\{\
		Comments.slider = new Dragdealer('comment-slider', \{\
			steps: 2,\
			callback: Comments.beforeAdd,\
			animationCallback: function(x, y)\
			\{\
				if(Comments.slider)\
				\{\
					var wrapper = Comments.slider.wrapper;\
					var bgOffset = Math.round((1 - x) * -wrapper.offsetWidth);\
					wrapper.style.backgroundPosition = String(bgOffset) + 'px 0px';\
				\}\
			\}\
		\});\
	\},\
	beforeAdd: function(value)\
	\{\
		var message = '';\
		s('#form_comment_range').set('value', value);\
		if(value)\
		\{\
			Comments.slider.disable();\
			Comments.add();\
			message = 'Wait for it...';\
		\}\
		else\
		\{\
			message = 'Come on, drag it.';\
		\}\
		s('#form-status').set('innerHTML', message);\
	\},\
	add: function()\
	\{\
		s('#comment-form').run(function()\
		\{\
			var params = \{\};\
			for(var i = 0; i < this.elements.length; i++)\
			\{\
				params[this.elements[i].name] = this.elements[i].value;\
			\}\
			Ajax.submit(this.action.changeExtension('ajax'),\
			\{\
				method: 'POST',\
				params: params,\
				callback: function()\
				\{\
					Comments.added(eval('(' + this.responseText + ')'));\
				\}\
			\});\
		\});\
	\},\
	added: function(response)\
	\{\
		if(response.status)\
		\{\
			this.clearForm();\
			this.update(response.comments_url);\
		\}\
		else\
		\{\
			this.showFormErrors(response.invalid_fields);\
			this.slider.setValue(0);\
			this.slider.enable();\
		\}\
		s('#form-status').set('innerHTML', response.message);\
	\},\
	update: function(url)\
	\{\
		Ajax.submit(url, \{ callback: function()\
		\{\
			s('ul#comments').set('innerHTML', this.responseText);\
			Comments.setupItems();\
		\}\});\
	\},\
	clear: function()\
	\{\
		for(var i = 0; i < this.items.length; i++)\
		\{\
			this.items[i].deselect();\
		\}\
	\},\
	toggle: function(item)\
	\{\
		if(item.selected())\
		\{\
			item.deselect();\
			this.setReplyId(0);\
		\}\
		else\
		\{\
			this.clear();\
			item.select();\
			this.setReplyId(item.id);\
			\
			s('#comment-form input[type=text]').first().run(function()\
			\{\
				this.focus();\
			\});\
			this.slider.setValue(0);\
			this.slider.enable();\
		\}\
	\},\
	setReplyId: function(id)\
	\{\
		s('#form_comment_in_reply_to_comment_id').set('value', id);\
	\},\
	clearForm: function()\
	\{\
		s('#comment-form li').run(function()\
		\{\
			this.className = this.className.replace(/\\s?invalid/, '');\
			\
			s(this).s(['input[type=text]', 'textarea']).set('value', '');\
		\});\
	\},\
	showFormErrors: function(invalid_fields)\
	\{\
		var pattern = new RegExp('^comment\\\\[(' + invalid_fields.join('|') + ')\\\\]$');\
			\
		s('#comment-form li').run(function()\
		\{\
			this.className = this.className.replace(/\\s?invalid/, '');\
			\
			var li = this;\
			s(this).s(['input[type=text]', 'textarea']).run(function()\
			\{\
				if(this.name.match(pattern))\
				\{\
					li.className += ' invalid';\
				\}\
			\});\
		\});\
	\}\
\};\
\
/* Comment */\
\
var Comment = function(listItem, anchor)\
\{\
	this.listItem = listItem;\
	this.anchor = anchor;\
	this.getId(anchor);\
	\
	var self = this;\
	this.anchor.onclick = function()\
	\{\
		Comments.toggle(self);\
		return false;\
	\}\
\};\
Comment.prototype =\
\{\
	getId: function(a)\
	\{\
		var matches = a.href.match(/reply_to=([0-9]+)$/);\
		this.id = matches ? Number(matches[1]) : 0;\
	\},\
	selected: function()\
	\{\
		return this.listItem.className.indexOf('selected') != -1;\
	\},\
	select: function()\
	\{\
		this.listItem.className += ' selected';\
	\},\
	deselect: function()\
	\{\
		this.listItem.className = this.listItem.className.replace(/\\s?selected/, '');\
	\}\
\};\
\
/* Main */\
\
var Main =\
\{\
	init: function()\
	\{\
		Items.init(['words', 'posts', 'categories', 'comments', 'tweets']);\
		Comments.init();\
	\}\
\};\
\
Event.add(window, 'load', function()\
\{\
	Main.init();\
\});\
}