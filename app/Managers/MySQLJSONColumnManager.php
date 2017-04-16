<?php

namespace App\Managers;

use Illuminate\Database\Eloquent\Model;

class MySQLJSONColumnManager
{
    /**
     *  The model instance
     * 
     *  @var mixed
     */
    protected $model;

    /**
     *  The list of data
     * 
     *  @var array
     */
    protected $data;

    /**
     *  The the model attribute name.
     * 
     *  @var string
     */
    protected $attribute;

    /**
     *  Create a new data instance
     * 
     *  @param \Illuminate\Database\Eloquent\Model $model
     *  @param  string $attribute
     */
    public function __construct(Model $model, string $attribute)
    {
        $this->model = $model;        
        $this->attribute = $attribute;

        $this->data = $model->$attribute ?: [];               
    }

    /**
     *  Retrieve a given setting
     * 
     *  @param  string $key
     *  @return string
     */
    public function get($key)
    {
        if ($this->has($key)) {
            return array_get($this->data, $key);
        }
    }

    /**
     *  Add a new item in the json column.
     * 
     *  @param array|string $key
     *  @param string $value
     */
    public function add($key, $value = null)
    {
        if (is_array($key)) {
            foreach ($key as $key => $value) {
                $this->data[$key] = $value;
            }
        } else {
            $this->data[$key] = $value;
        }

        $this->persist();
    }

    /**
     *  Remove item from the data.
     * 
     *  @param  array|string $key
     *  @return mixed
     */
    public function delete($key)
    {
        $exist = false;

        if (is_array($key)) {            
            foreach ($key as $value) {
                if (isset($this->data[$value])) {
                    unset($this->data[$value]);
                    $exist = true;
                }
            }
        }

        if (is_string($key) && isset($this->data[$key])) {
            unset($this->data[$key]);
            $exist = true;
        }

        if ($exist) {
            return $this->persist(); 
        }
    }

    /**
     *  Retrieve an array of all data
     * 
     *  @return array
     */
    public function all()
    {
        return $this->data;
    }

    /**
     *  Determine if the given setting exists.
     * 
     *  @param  string  $key
     *  @return boolean
     */
    protected function has($key)
    {
        return array_key_exists($key, $this->data);
    }

    /**
     *  Update an item in the json column.
     * 
     *  @param  array|string $key
     *  @param  string $value
     *  @return mixed
     */
    public function update($key, $value = null)
    {
        if (! is_array($key)) {
            $key = [$key => $value];
        }

        $this->data = array_merge(
            $this->data,
            array_only($key, array_keys($this->data))
        );

        $this->persist();
    }

    /**
     *  Persist the data
     * 
     *  @return mixed
     */
    protected function persist()
    {
        return $this->model->update([$this->attribute => $this->data]);
    }

    /**
     *  Magic property access for data
     * 
     *  @param  string $key
     *  @return string
     */
    public function __get($key)
    {
        return $this->get($key);              
    }
}