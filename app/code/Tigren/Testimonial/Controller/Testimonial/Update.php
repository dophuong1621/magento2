<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2022 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 */

namespace Tigren\Testimonial\Controller\Testimonial;

use Exception;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\View\Result\Page;
use Magento\Framework\View\Result\PageFactory;
use Tigren\Testimonial\Model\TestimonialFactory;

/**
 * Class Update
 * @package Tigren\Testimonial\Controller\Testimonial
 */
class Update extends Action
{
    /**
     * @var TestimonialFactory
     */
    protected $testimonialFactory;

    /**
     * @var PageFactory
     */
    protected $pageFactory;

    /**
     * @param TestimonialFactory $testimonialFactory
     * @param Context $context
     * @param PageFactory $pageFactory
     */
    public function __construct(
        TestimonialFactory $testimonialFactory,
        Context $context,
        PageFactory $pageFactory,
    ) {
        $this->testimonialFactory = $testimonialFactory;
        $this->pageFactory = $pageFactory;
        return parent::__construct($context);
    }

    /**
     * @return Page|Redirect|ResultInterface
     * @throws Exception
     */
    public function execute()
    {
        $data = $this->getRequest()->getParams();
        $id = $data['id'];

        $testimonial = $this->testimonialFactory->create()->load($id);
        if ($id) {
            $testimonial->setData('name', $data['name']);
            $testimonial->setData('email', $data['email']);
            $testimonial->setData('message', $data['message']);
            $testimonial->setData('company', $data['company']);
            $testimonial->setData('rating', $data['rating']);
            $testimonial->setData('status', $data['status']);
            $testimonial->save();
            $this->messageManager->addSuccessMessage(__('You update the question success.'));
            return $this->resultRedirectFactory->create()->setPath('testimonial/testimonial/index');
        } else {
            $this->messageManager->addErrorMessage('Error');
            return $this->pageFactory->create();
        }
    }
}
