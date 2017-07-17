import React from 'react';
import QueueAnim from 'rc-queue-anim';
import TweenOne from 'rc-tween-one';
import OverPack from 'rc-scroll-anim/lib/ScrollOverPack';

class Content extends React.Component {

  static propTypes = {
    id: React.PropTypes.string,
  };

  static defaultProps = {
    className: 'content7',
  };

  getBlockChildren = (item, i) =>(
    <li key={i} id={`${this.props.id}-block${i}`}>
      <div className="icon">
        <img src={item.icon} width="100%"  />
      </div>
      <h3>{item.title}</h3>
      <p>{item.content}</p>
      <p><a href={item.link}>{item.label}</a>
      </p>
    </li>);

  render() {
    const props = { ...this.props };
    delete props.isMode;
    const dataSource = [
      { icon: 'http://images.51guanggao.cc/photo/09.png', title: '大众广告', content: '永久免费发布招聘求职、房产、汽车、购物、交友信息。' ,link:'#',label:''},
      { icon: 'http://images.51guanggao.cc/photo/barcode_ios.png', title: '苹果 ios', content: '扫码下载',link:'https://itunes.apple.com/cn/app/%E5%A4%A7%E4%BC%97%E5%B9%BF%E5%91%8A/id1233987952?mt=8',label:'或点击这里立即下载' },
      { icon: 'http://images.51guanggao.cc/photo/barcode.png', title: '安卓 Android', content: '扫码下载',link:'http://sj.qq.com/myapp/detail.htm?apkName=com.yangshunfu.mass',label:'或点击这里立即下载' },
    ];
    const listChildren = dataSource.map(this.getBlockChildren);
    return (
      <div
        {...props}
        className={`content-template-wrapper ${props.className}-wrapper`}
      >
        <OverPack
          className={`content-template ${props.className}`}
          location={props.id}
        >
          <TweenOne
            animation={{ y: '+=30', opacity: 0, type: 'from' }}
            component="h1"
            key="h1"
            reverseDelay={300}
            id={`${props.id}-title`}
          >
            APP下载
          </TweenOne>
          <QueueAnim
            component="ul" type="bottom" key="block" leaveReverse
            id={`${props.id}-contentWrapper`}
          >
            {listChildren}
          </QueueAnim>
        </OverPack>
      </div>
    );
  }
}

export default Content;
