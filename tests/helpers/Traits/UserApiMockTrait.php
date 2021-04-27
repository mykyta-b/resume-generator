<?php

declare(strict_types=1);

namespace App\Tests\Helpers\Traits;

use PHPUnit\Framework\MockObject\MockObject;
use Exception;
use Ramsey\Uuid\Uuid;

trait UserApiMockTrait
{
    /**
     * @return MockObject
     */
    private function mockUserApiResponse(): string
    {
        return '{
           "login":"mxcl",
           "id":58962,
           "node_id":"MDQ6VXNlcjU4OTYy",
           "avatar_url":"https://avatars.githubusercontent.com/u/58962?v=4",
           "gravatar_id":"",
           "url":"https://api.github.com/users/mxcl",
           "html_url":"https://github.com/mxcl",
           "followers_url":"https://api.github.com/users/mxcl/followers",
           "following_url":"https://api.github.com/users/mxcl/following{/other_user}",
           "gists_url":"https://api.github.com/users/mxcl/gists{/gist_id}",
           "starred_url":"https://api.github.com/users/mxcl/starred{/owner}{/repo}",
           "subscriptions_url":"https://api.github.com/users/mxcl/subscriptions",
           "organizations_url":"https://api.github.com/users/mxcl/orgs",
           "repos_url":"https://api.github.com/users/mxcl/repos",
           "events_url":"https://api.github.com/users/mxcl/events{/privacy}",
           "received_events_url":"https://api.github.com/users/mxcl/received_events",
           "type":"User",
           "site_admin":false,
           "name":"Max Howell",
           "company":null,
           "blog":"https://mxcl.dev",
           "location":"Savannah, GA",
           "email":null,
           "hireable":null,
           "bio":null,
           "twitter_username":"mxcl",
           "public_repos":57,
           "public_gists":45,
           "followers":6094,
           "following":28,
           "created_at":"2009-02-28T22:54:13Z",
           "updated_at":"2021-04-14T16:22:46Z"
        }';
    }

    /**
     * @return MockObject
     */
    private function mockUserApiErrorEmptyResponse(): string
    {
        return '{
           "login":"asdfasdfasd",
           "id":345697,
           "node_id":"MDQ6VXNlcjM0NTY5Nw==",
           "avatar_url":"https://avatars.githubusercontent.com/u/345697?v=4",
           "gravatar_id":"",
           "url":"https://api.github.com/users/asdfasdfasd",
           "html_url":"https://github.com/asdfasdfasd",
           "followers_url":"https://api.github.com/users/asdfasdfasd/followers",
           "following_url":"https://api.github.com/users/asdfasdfasd/following{/other_user}",
           "gists_url":"https://api.github.com/users/asdfasdfasd/gists{/gist_id}",
           "starred_url":"https://api.github.com/users/asdfasdfasd/starred{/owner}{/repo}",
           "subscriptions_url":"https://api.github.com/users/asdfasdfasd/subscriptions",
           "organizations_url":"https://api.github.com/users/asdfasdfasd/orgs",
           "repos_url":"https://api.github.com/users/asdfasdfasd/repos",
           "events_url":"https://api.github.com/users/asdfasdfasd/events{/privacy}",
           "received_events_url":"https://api.github.com/users/asdfasdfasd/received_events",
           "type":"User",
           "site_admin":false,
           "name":null,
           "company":null,
           "blog":"",
           "location":null,
           "email":null,
           "hireable":null,
           "bio":null,
           "twitter_username":null,
           "public_repos":0,
           "public_gists":0,
           "followers":0,
           "following":0,
           "created_at":"2010-07-27T12:30:24Z",
           "updated_at":"2015-04-09T20:01:47Z"
        }';
    }

    public function mockUserApiErrorResponse()
    {
        return '{
          "message": "Not Found",
          "documentation_url": "https://docs.github.com/rest/reference/users#get-a-user"
        }';
    }
}

