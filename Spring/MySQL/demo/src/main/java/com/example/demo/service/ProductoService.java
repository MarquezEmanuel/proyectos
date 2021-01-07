package com.example.demo.service;

import com.example.demo.entity.Producto;
import com.example.demo.repository.ProductoRepository;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import java.util.List;

@Service
public class ProductoService {

    @Autowired
    private ProductoRepository repository;

    public Producto saveProduct(Producto producto) {
        return repository.save(producto);
    }

    public List<Producto> getProducts() {
        return repository.findAll();
    }

    public Producto getProductById(int id) {
        return repository.findById(id).orElse(null);
    }
}
