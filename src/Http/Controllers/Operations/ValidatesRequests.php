<?php
namespace ViralsBackpack\BackPackAPI\Http\Controllers\Operations;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Contracts\Validation\Factory;
use Illuminate\Validation\ValidationException;

trait ValidatesRequests
{
    public $requestStoreApi;
    public $requestUpdateApi;

    /**
     * Run the validation routine against the given validator.
     *
     * @param  \Illuminate\Contracts\Validation\Validator|array  $validator
     * @param  \Illuminate\Http\Request|null  $request
     * @return array
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function validateWith($validator, Request $request = null)
    {
        $request = $request ?: request();

        if (is_array($validator)) {
            $validator = $this->getValidationFactory()->make($request->all(), $validator);
        }

        return $validator->validate();
    }

    /**
     * Validate the given request with the given rules.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  array  $rules
     * @param  array  $messages
     * @param  array  $customAttributes
     * @return array
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function validate(Request $request, array $rules,
                             array $messages = [], array $customAttributes = [])
    {
        return $this->getValidationFactory()->make(
            $request->all(), $rules, $messages, $customAttributes
        )->validate();
    }

    /**
     * Validate the given request with the given rules.
     *
     * @param  string  $errorBag
     * @param  \Illuminate\Http\Request  $request
     * @param  array  $rules
     * @param  array  $messages
     * @param  array  $customAttributes
     * @return array
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function validateWithBag($errorBag, Request $request, array $rules,
                                    array $messages = [], array $customAttributes = [])
    {
        try {
            return $this->validate($request, $rules, $messages, $customAttributes);
        } catch (ValidationException $e) {
            $e->errorBag = $errorBag;

            throw $e;
        }
    }

    /**
     * Get a validation factory instance.
     *
     * @return \Illuminate\Contracts\Validation\Factory
     */
    protected function getValidationFactory()
    {
        return app(Factory::class);
    }

    public function setRequestStoreApi($class)
    {
        $this->requestStoreApi = $class;
        return $this->requestStoreApi;
    }

    public function setRequestUpdateApi($class)
    {
        $this->requestUpdateApi = $class;
        return $this->requestUpdateApi;
    }

    public function validateApi($operation, $request)
    {
        switch ($operation) {
            case "create":
                $formRequest = new $this->requestStoreApi;
                break;
            case "edit":
                $formRequest = new $this->requestUpdateApi;
                break;
        }
        $rules = $formRequest->rules();
        $messages = $formRequest->messages();
        $attributes = $formRequest->attributes();
        if (count($rules)) {
            $validator = Validator::make($request->all(), $rules, $messages, $attributes);
            if ($validator->fails()) {
                $errors = '';
                foreach ( $validator->messages()->toArray() as $error) {
                    $errors .= implode(',', $error) . ' ';
                }
                return [
                    'message' => $errors,
                    'status' => 422
                ];
            }
        }
        return [
            'message' => 'Validate api request done',
            'status' => 200
        ];
    }
}