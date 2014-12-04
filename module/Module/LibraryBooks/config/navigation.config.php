<?php
return [
    'navigation' => [
        'default' => [
            'Module\\LibraryBooks' => [
                'label' => 'Books in library',
                'route' => 'library/books',
                'resource' => 'module\\librarybooks',
                'controller' => 'index',
                'action' => 'index',
                'privilege' => 'index:index',
                'order' => 2,
                'pages' => [
                    'create' => [
                        'label' => 'Create',
                        'route' => 'library/books/create',
                        'resource' => 'module\\librarybooks',
                        'controller' => 'create',
                        'action' => 'index',
                        'privilege' => 'create:index',
                    ],
                    'read' => [
                        'label' => 'Read',
                        'route' => 'library/books/read',
                        'resource' => 'module\\librarybooks',
                        'controller' => 'read',
                        'action' => 'index',
                        'privilege' => 'read:index',
                    ],
                    'update' => [
                        'label' => 'Update',
                        'route' => 'library/books/update',
                        'resource' => 'module\\librarybooks',
                        'controller' => 'update',
                        'action' => 'index',
                        'privilege' => 'update:index',
                    ],
                    'delete' => [
                        'label' => 'Delete',
                        'route' => 'library/books/delete',
                        'resource' => 'module\\librarybooks',
                        'controller' => 'delete',
                        'action' => 'index',
                        'privilege' => 'delete:index',
                    ]
                ]
            ],
        ],
    ]
];
