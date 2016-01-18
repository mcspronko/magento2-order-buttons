<?php

namespace Pronko\Magento2OrderButtons\Plugin\Block\Widget\Button;

use Magento\Backend\Block\Widget\Button\Toolbar as ToolbarContext;
use Magento\Framework\View\Element\AbstractBlock;
use Magento\Backend\Block\Widget\Button\ButtonList;

class Toolbar
{
    /**
     * @param ToolbarContext $toolbar
     * @param AbstractBlock $context
     * @param ButtonList $buttonList
     * @return array
     */
    public function beforePushButtons(
        ToolbarContext $toolbar,
        \Magento\Framework\View\Element\AbstractBlock $context,
        \Magento\Backend\Block\Widget\Button\ButtonList $buttonList
    ) {
        if (!$context instanceof \Magento\Sales\Block\Adminhtml\Order\View) {
            return [$context, $buttonList];
        }
        $buttonList->update('order_edit', 'class', 'edit');
        $buttonList->update('order_invoice', 'class', 'invoice primary');
        $buttonList->update('order_invoice', 'sort_order', (count($buttonList->getItems()) + 1) * 10);

        $buttonList->add('order_review',
            [
                'label' => __('Review'),
                'onclick' => 'setLocation(\'' . $context->getUrl('sales/*/review') . '\')',
                'class' => 'review'
            ]
        );

        $buttonList->remove('order_hold');
        $buttonList->remove('send_notification');

        return [$context, $buttonList];
    }
}