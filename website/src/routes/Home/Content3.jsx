import React from 'react';
import QueueAnim from 'rc-queue-anim';
import TweenOne from 'rc-tween-one';
import OverPack from 'rc-scroll-anim/lib/ScrollOverPack';

class Content extends React.Component {

  static defaultProps = {
    className: 'content1',
  };

  render() {
    const props = { ...this.props };
    const isMode = props.isMode;
    delete props.isMode;
    const animType = {
      queue: isMode ? 'bottom' : 'left',
      one: isMode ? { y: '+=30', opacity: 0, type: 'from' }
        : { x: '+=30', opacity: 0, type: 'from' },
    };
    return (
      <div
        {...props}
        className={`content-template-wrapper content-half-wrapper ${props.className}-wrapper`}
      >
        <OverPack
          className={`content-template ${props.className}`}
          location={props.id}
        >
          <QueueAnim
            type={animType.queue}
            className={`${props.className}-text`}
            key="text"
            leaveReverse
            ease={['easeOutCubic', 'easeInCubic']}
            id={`${props.id}-textWrapper`}
          >
           <div key="p" id={`${props.id}-content`}>
            <h1 key="h1" id={`${props.id}-title`}>
              保证金模式(购物类)
            </h1>
           
             <p> 1、商家发布信息，不用支付保证金</p>
							<p>2、客户购买时，支付全款保证金到大众广告</p>
						<p>3、商家看到客户支付信息，然后发货</p>
              <p>4、客户收到货后，在履行期内，按商家在大众广告预留的收款方式付款给商家</p>
            <p>5、双方确认履行后，客户保证金过了申诉期退回到客户帐户，以备下次继续使用</p>
            </div>
          </QueueAnim>
          <TweenOne
            key="img"
            animation={animType.one}
            className={`${props.className}-img`}
            id={`${props.id}-imgWrapper`}
            resetStyleBool
          >
            <span id={`${props.id}-img`}>
              <img width="100%" src="http://images.51guanggao.cc/photo/16.png" />
            </span>
          </TweenOne>
        </OverPack>
      </div>
    );
  }
}

export default Content;
