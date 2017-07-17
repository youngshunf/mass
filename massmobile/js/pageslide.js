// PageSlide
var PageSlide = function(el, swipe, options) {
  this.options = options || {}
  this.current = 0
  this.pageX
  this.pageY
  this.height
  this.width
  this.flag
  this.move

  this.$el = el
  this.swipe = swipe || 'X'
  this.resize().init().bindEvents()
}

PageSlide.prototype.init = function(i) {
  var current = i ? this.$el.children[i] : this.$el.firstElementChild
  if (!current) throw 'ERROR';

  current.classList.add('moving')
  current.style.webkitTransform = 'translate3d(0,0,0)'

for(var i = 1; i <this.$el.children.length ; i++){
		this['set' + this.swipe](this.$el.children[i],  (this.swipe === 'X' ? this.width : this.height)) 
		}

  setTimeout(function() {
    current.classList.remove('moving')
    current.classList.add('play')
  }, 3e2)
  return this
}

PageSlide.prototype.bindEvents = function() {
  var self = this

  window.addEventListener('resize orientationchange', this.resize.bind(this), false)

  'touchstart touchmove touchend touchcancel'.split(' ').forEach(function(evn) {
    self.$el.addEventListener(evn, self[evn].bind(self), false)
  })
}

PageSlide.prototype.getCurrent = function() {
  return this.$el.children[this.current]
}

PageSlide.prototype.resize = function() {
  this.width = this.$el.parentNode.clientWidth
  this.height = this.$el.parentNode.clientHeight
  return this
}

PageSlide.prototype.random = function() {
  var count = this.$el.children.length
  var current = this.current
  var arr = []
  var num

  for (var i = 0; i < count; i++) {
    if (i !== current) arr.push(i.toString())
  }

  num = Math.floor(Math.random() * arr.length)
  this.direct(+arr[num])
}

PageSlide.prototype.touchstart = function(e) {
  var touches = e.touches[0]

  //touch start initializing
  this.flag = null
  this.move = 0

  //record coordinates
  this.pageX = touches.pageX
  this.pageY = touches.pageY
}

PageSlide.prototype.touchmove = function(e) {
  var touches = e.touches[0]
  var X = touches.pageX - this.pageX
  var Y = touches.pageY - this.pageY

  var current = this.getCurrent()
  var next = current.nextElementSibling
  var prev = current.previousElementSibling

  //add moving styled

  if (!this.flag) {
    this.flag = Math.abs(X) > Math.abs(Y) ? 'X' : 'Y'

    if (this.flag === this.swipe) {
      current.classList.add('moving')
      next && next.classList.add('moving')
      prev && prev.classList.add('moving')
    }
  }

  if (this.flag === this.swipe) {
    e.preventDefault()
    e.stopPropagation()

    switch (this.swipe) {
      case 'X':
        //swipe horizontal
        this.move = X

        this.setX(current, X)
        next && (this.setX(next, X + this.width))
        prev && (this.setX(prev, X - this.width))
        break;
      case 'Y':
        //swipe vertical
        this.move = Y

        this.setY(current, Y)

        next && (this.setY(next, Y + this.height))
        prev && (this.setY(prev, Y - this.height))
        break;
    }
  }
}

PageSlide.prototype.touchend = function(e) {
  var minRange = 50
  var move = this.move
  var current = this.getCurrent()
  var next = current.nextElementSibling
  var prev = current.previousElementSibling

  current.classList.remove('moving')
  next && next.classList.remove('moving')
  prev && prev.classList.remove('moving')
  if (!this.flag) return

  e.preventDefault()

  if (move < -minRange && next) return this.next()
  if (move > minRange && prev){
    alert('next');
    return this.prev()}
  this.reset()
}

PageSlide.prototype.touchcancel = function(e) {
  var current = this.getCurrent()
  var next = current.nextElementSibling
  var prev = current.previousElementSibling

  current.classList.remove('moving')
  next && next.classList.remove('moving')
  prev && prev.classList.remove('moving')
  this.reset()
}

PageSlide.prototype.setX = function(el, x, unit) {
  el && (el.style.webkitTransform = 'translate3d(' + x + (unit || 'px') + ',0,0)')
}

PageSlide.prototype.setY = function(el, y, unit) {
  el && (el.style.webkitTransform = 'translate3d(0,' + y + (unit || 'px') + ',0)')
}

PageSlide.prototype.setCurrent = function(el, i) {
  el && (el.style.webkitTransform = 'translate3d(0,0,0)')

  if (i) {
    this.current = i
    this.$current = this.$el.children[i]
  }

}

PageSlide.prototype.next = function() {
  this.go(this.current + 1)
}

PageSlide.prototype.prev = function() {
  this.go(this.current - 1)
}

PageSlide.prototype.reset = function() {
  var width = this.width
  var height = this.height
  var swipe = this.swipe
  var current = this.getCurrent()
  var prev = current.previousElementSibling
  var next = current.nextElementSibling

  this.setCurrent(current)
  prev && (this['set' + swipe](prev, -(swipe === 'X' ? width : height)))
  next && (this['set' + swipe](next, swipe === 'X' ? width : height))
}

PageSlide.prototype.go = function(i) {
  var onFinish = this.options.onFinish
  var current = this.getCurrent()
  var total = this.$el.childElementCount
  var target = this.$el.children[i]
  var d = i < this.current ? -1 : 1

  if (i === this.current || i < 0 || i >= total) return
  if (onFinish && (typeof onFinish === 'function')) onFinish.call(this, i)
    // 滑动完成调用方法
  typeof this.options.tranSetionEnd === 'function' && this.options.tranSetionEnd.call(this)
  this.current = i

  this['set' + this.swipe](current /*初始的current为0*/ , -d * (this.swipe === 'X' ? this.width : this.height))
  this.setCurrent(target, i)
  this.finish(current, target)
}

PageSlide.prototype.finish = function(curr, target) {
  this.flag = null
  setTimeout(function() {
    curr && curr.classList.remove('play')
    target && target.classList.add('play')
  }, 3e2)
}

/*direct to a page*/
PageSlide.prototype.direct = function(i) {
    if (i && typeof(i) === 'number') {
      this.go(i)
      for (var j = 0; j < i; j++) {
        this['set' + this.swipe](this.$el.children[j], -1 * (this.swipe === 'X' ? this.width : this.height))
      }
    } else return

  }
  /* 传参 */
document.addEventListener('touchmove', function(e) {
  e.preventDefault()
})
var pages = new PageSlide(document.querySelector('.pages'), 'X', {
  tranSetionEnd: function() {
    console.log(this.current);
  }
})