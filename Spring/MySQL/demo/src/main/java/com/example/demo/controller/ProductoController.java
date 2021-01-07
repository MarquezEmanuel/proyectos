package com.example.demo.controller;

import com.example.demo.entity.Producto;
import com.example.demo.service.ProductoService;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Controller;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.PostMapping;
import org.springframework.web.bind.annotation.RequestBody;
import org.springframework.web.bind.annotation.RestController;

import java.util.List;

@RestController
public class ProductoController {

    @Autowired
    private ProductoService service;

    @PostMapping("/addProduct")
    public Producto addProducto(@RequestBody Producto producto) {
        return service.saveProduct(producto);
    }

    @GetMapping("/products")
    public List<Producto> getProductos(){
        return service.getProducts();
    }

}
