<?php

namespace Skillcraft\Core\Supports;

use FacebookAds\Object\Page as FacebookPage;
use Illuminate\Support\Collection;
use FacebookAds\Api as FacebookApiSDK;
use Skillcraft\Core\Abstracts\MetaBusinessApiAbstract;
use FacebookAds\Object\AdAccount as FacebookAdsAdAccount;
use Skillcraft\Core\Contracts\MetaBusinessApiCredentialsContract;

class MetaBusiness extends MetaBusinessApiAbstract
{
    public MetaBusinessApiCredentialsContract $credentials = null;

    public function __construct(MetaBusinessApiCredentialsContract $credentials)
    {
        $this->credentials = $credentials;
    }

    public function getCredentials(): MetaBusinessApiCredentialsContract
    {
        return $this->credentials;
    }

    public function getClient(): FacebookApiSDK
    {
        FacebookApiSDK::init(
            $this->credentials->appId,
            $this->credentials->appSecret,
            $this->credentials->pageAccessToken,
        );

        return FacebookApiSDK::instance();
    }

    public function getAdAccount(): FacebookAdsAdAccount
    {
        return new FacebookAdsAdAccount($this->credentials->pageId);
    }

    public function getPage(): FacebookPage
    {
        return new FacebookPage($this->credentials->pageId);
    }

    public function getPageConversations():Collection
    {
        $fields = "id,snippet,can_reply,link,message_count,unread_count";

        $page = $this->getPage();

        $conversations = $page->getConversations([
            'fields' => $fields
        ]);

        $result = [];

        foreach ($conversations as $conversation) {
            array_push($result, [
                'id' => $conversation->id,
                'snippet' => $conversation->snippet,
                'can_reply' => $conversation->can_reply,
                'link' => $conversation->link,
                'message_count' => $conversation->message_count,
                'unread_count' => $conversation->unread_count,
            ]);
        }

        return collect($result);
    }

    public function getPageGroups():Collection
    {
        $page = $this->getPage();

        $groups = $page->getGroups([]);

        $result = [];

        foreach ($groups as $group) {
            array_push($result, [
                'id' => $group->id,
                'name' => $group->name,
            ]);
        }

        return collect($result);
    }
}
