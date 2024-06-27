<?php

namespace Docs;

use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\Response;

#[OA\OpenApi(
    info: new OA\Info(
        version: '1.0.0',
        description: 'Exchange Rates Rest API',
        title: 'Jaya Exchange'
    )
), OA\Post(
    path: '/transactions',
    tags: ['transactions'],
    description: 'Create a transaction',
    requestBody: new OA\RequestBody(required: true, content: new OA\JsonContent(ref: '#/components/schemas/StoreTransactionRequest')),
    responses: [
        new OA\Response(response: Response::HTTP_CREATED, description: 'Transaction created', content: new OA\JsonContent(
            ref: '#/components/schemas/TransactionResource'
        )),
        new OA\Response(response: Response::HTTP_UNPROCESSABLE_ENTITY, description: 'Invalid data', content: new OA\JsonContent(properties: [
            new OA\Property(property: 'message', type: 'string', example: 'The selected from is invalid. (and 1 more error)'),
            new OA\Property(
                property: 'errors',
                type: 'object',
                properties: [new OA\Property(type: 'array', description: 'attibute name', items: new OA\Items(type: 'string', description: 'error message'))],
                example: [
                    'from' => ['The selected from is invalid.'],
                    'to' => ['The selected to is invalid.'],
                ]
            ),
        ])),
        new OA\Response(response: Response::HTTP_SERVICE_UNAVAILABLE, description: 'External service error', content: new OA\JsonContent(
            properties: [new OA\Property(property: 'message', type: 'string', default: 'Something wrong with our external services, contact a admin')]
        )),
    ]
), OA\Get(
    path: '/transactions/{user_id}',
    parameters: [new OA\Parameter(name: 'user_id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'), example: '1')],
    tags: ['transactions'],
    description: 'User transactions paginated list',
    responses: [
        new OA\Response(response: Response::HTTP_OK, description: 'Success', content: new OA\JsonContent(properties: [
            new OA\Property(property: 'data', type: 'array', items: new OA\Items(ref: '#/components/schemas/TransactionResource')),
            new OA\Property(property: 'links', type: 'object', properties: [
                new OA\Property(property: 'first', type: 'string', example: 'https://host-url/transactions/1?page=1'),
                new OA\Property(property: 'last', type: 'string', example: 'https://host-url/transactions/1?page=2'),
                new OA\Property(property: 'prev', type: 'string', example: null),
                new OA\Property(property: 'next', type: 'string', example: 'https://host-url/transactions/1?page=2'),
            ]),
            new OA\Property(property: 'meta', type: 'object', properties: [
                new OA\Property(property: 'current_page', type: 'integer', example: 1),
                new OA\Property(property: 'from', type: 'integer', example: 1),
                new OA\Property(property: 'path', type: 'string', example: 'https://host-url/transactions/1'),
                new OA\Property(property: 'per_page', type: 'integer', example: 15),
                new OA\Property(property: 'to', type: 'integer', example: 15),
            ]),
        ])),
        new OA\Response(response: Response::HTTP_NOT_FOUND, description: 'User not found', content: new OA\JsonContent(
            properties: [new OA\Property(property: 'message', type: 'string', default: 'User not found')]
        )),
    ]
), OA\Schema(
    schema: 'TransactionResource',
    properties: [
        new OA\Property(property: 'id', type: 'integer', example: 1),
        new OA\Property(property: 'user_id', type: 'integer', example: 1),
        new OA\Property(property: 'from', type: 'string', example: 'BRL'),
        new OA\Property(property: 'amount', type: 'number', example: 12.55),
        new OA\Property(property: 'to', type: 'string', example: 'USD'),
        new OA\Property(property: 'result', type: 'number', example: 231.54877318093025),
        new OA\Property(property: 'rate', type: 'number', example: 18.4501014486797),
        new OA\Property(property: 'created_at', type: 'string', example: '2024-06-27T17:19:28.000000Z'),
    ]
), OA\Schema(
    schema: 'StoreTransactionRequest',
    required: ['user_id', 'from', 'amount', 'to'],
    properties: [
        new OA\Property(property: 'user_id', type: 'integer', example: 1),
        new OA\Property(property: 'from', type: 'string', example: 'BRL'),
        new OA\Property(property: 'amount', type: 'number', example: 12.55),
        new OA\Property(property: 'to', type: 'string', example: 'USD'),
    ]
)]
class OpenApiSpecification {}
