import React from 'react';
import QueueAnim from 'rc-queue-anim';
import TweenOne from 'rc-tween-one';
import OverPack from 'rc-scroll-anim/lib/ScrollOverPack';

class Content extends React.Component {
  static defaultProps = {
    className: 'content0',
  };

  render() {
    const props = { ...this.props };
    const isMode = props.isMode;
    delete props.isMode;
    const animType = {
      queue: isMode ? 'bottom' : 'right',
      one: isMode ? { y: '+=30', opacity: 0, type: 'from' }
        : { x: '-=30', opacity: 0, type: 'from' },
    }
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
          className={`${props.className}-text`}
          type={animType.queue}
          key="text"
          leaveReverse
          ease={['easeOutCubic', 'easeInCubic']}
          id={`${props.id}-textWrapper`}
        >
          <h1 key="h1" id={`${props.id}-title`}>
            购物流程
          </h1>
          <p key="p" id={`${props.id}-content`}>
          1、客户点击立即购买，弹出界面，可以在填写购买数量和留言后，点击确定即下订单
          2、下订单后，出现支付界面，客户支付保证金前，可以新增或修改收货地址，但是，支付保证金后不得再修改收货地址
          3、客户支付保证金前可以取消订单
          4、商家看到客户支付信息后，按照收货地址发货
          5、客户收到货后，在履行期内，按商家在大众广告预留的收款方式付款给商家，并确认履行
          6、商家收到款后，确认履行，客户保证金过了申诉期退回到客户帐户

          </p>
        </QueueAnim>
          <TweenOne
            key="img"
            animation={animType.one}
            className={`${props.className}-img`}
            id={`${props.id}-imgWrapper`}
            resetStyleBool
          >
            <span id={`${props.id}-img`}>
              <img width="100%" src="http://images.51guanggao.cc/photo/01.png" />
            </span>
          </TweenOne>

        </OverPack>
      </div>
    );
  }
}


export default Content;
